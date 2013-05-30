<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 17:49
 */

namespace Jungle\SLR;


use Jungle\Parser\Rule;
use Jungle\Parser\RuleSet;
use Jungle\Parser\RuleSet\Container;
use Jungle\Syntax;

class Table
{

    const GLOBAL_TOKEN = 'E';

    /**
     * Start token
     */
    const START_TOKEN = '__START__';

    /**
     * End token
     */
    const END_TOKEN = '__END__';

    /**
     * End token
     */
    const EPSILON_TOKEN = '__EPSILON__';

    /**
     * @var Container
     */
    protected $left;

    /**
     * @var Container
     */
    protected $right;

    /**
     * @var RuleSet
     */
    protected $ordered;

    /**
     * @var array
     */
    protected $terminals;

    /**
     * @var array
     */
    protected $nonterminals;

    /**
     * @var TransitionSet
     */
    protected $transition;

    /**
     * @var array
     */
    protected $table;

    /**
     *
     */
    public function __construct()
    {
        $this->left = new Container();
        $this->right = new Container();
        $this->ordered = new RuleSet();

        $this->terminals = [self::END_TOKEN];
        $this->nonterminals = []; //new RuleSet();

//        $this->terminals->addRule(new Rule('EOF'));
    }

    /**
     * @param Syntax $syntax
     */
    public function fromSyntax(Syntax $syntax)
    {
        $startRule = new Rule();
        $startRule->setId(0);
        $startRule->setLeft(self::START_TOKEN);
        $startRule->setRight(array(self::GLOBAL_TOKEN));

        $this->nonterminals[] = $startRule->getLeft();
        $this->ordered->addRule($startRule);

        $this->left->getRuleSet($startRule->getLeft())->addRule($startRule);
        $this->right->getRuleSet(self::GLOBAL_TOKEN)->addRule($startRule);

        foreach ($this->addRules($syntax) as $token) {
            if ($this->left->hasRuleSet($token)) {
                $this->nonterminals[] = $token;
            } else {
                $this->terminals[] = $token;
            }
        }

        $this->transition = new TransitionSet($this);
        $this->transition->process();
        $this->calculateTable();

        return $this->table;
    }

    /**
     * Calculate SLR table
     */
    protected function calculateTable()
    {
        $table = array();

        /** @var State $state */
        foreach ($this->transition as $state) {
            $table[$state->getId()] = $this->calculateTableRow($state);
        }

        $this->table = $table;
    }

    /**
     * @param State $state
     *
     * @return array
     */
    protected function calculateTableRow(State $state)
    {
        $row = array();
        foreach ($state->getTransitions() as $token => $transition) {
            if ($this->isTerminal($token)) {
                $row[$token] = array('shift', $transition->getId());
            } else {
                $row[$token] = array('transition', $transition->getId());
            }
        }

        foreach ($state->getSituationSet()->getIterator() as $situation) {
            if (!$situation->hasNext()) {
                if ($situation->getRule()->getLeft() == self::START_TOKEN) {
                    $action = array('accept');
                } else {
                    $action = array(
                        'reduce',
                        //$situation->getRule()->getId(),
                        'callback' => $situation->getRule()->getCallback(),
                        'right' => count($situation->getRule()->getRight()),
                        'left' => $situation->getRule()->getLeft()
                    );
                }

                foreach ($this->getFollowTokens($situation->getRule()->getLeft()) as $token) {
                    if (isset($row[$token])) {
                        if ($row[$token][0] == 'reduce') {
                            if ($situation->getRule()->getId() < $row[$token][1]) {
                                $row[$token] = $action;
                            }
                        }
                    } else {
                        $row[$token] = $action;
                    }
                }
            }
        }

        return $row;
    }

    /**
     * @param Syntax $syntax
     *
     * @return array
     */
    public function addRules(Syntax $syntax)
    {
        $tokens = [];

        foreach ($syntax->getTokens() as $token) {
            foreach ($token->getExpressions() as $expression) {
                $rule = new Rule();
                $rule->setLeft($token->getName());
                $rule->setRight($expression->getTokens());
                $rule->setCallback($expression->getCallback());

                $this->left->getRuleSet($token->getName())->addRule($rule);
                $this->ordered->addRule($rule);

                foreach ($rule->getRight() as $right) {
                    $this->right->getRuleSet($right)->addRule($rule);
                    $tokens[] = $right;
                }
            }
        }

        $tokens = array_unique($tokens);

        return $tokens;
    }

    /**
     * @param Rule $rule
     * @param string $tokenName
     */
    public function addRule(Rule $rule, $tokenName)
    {
        $this->left->getRuleSet($tokenName)->addRule($rule);
        $this->ordered->addRule($rule);

        foreach ($rule->getRight() as $right) {
            $this->right->getRuleSet($right)->addRule($rule);
        }
    }

    /**
     * @return Rule
     */
    public function getStartRule()
    {
        return $this->ordered->getRule(0);
    }

    /**
     * @param string $name
     *
     * @return \Jungle\Parser\RuleSet
     */
    public function getLeftRulesByName($name)
    {
        return $this->left->getRuleSet($name)->getRules();
    }

    /**
     * @param string $token
     *
     * @return bool
     */
    protected function isTerminal($token)
    {
        return array_search($token, $this->terminals) !== false;
    }

    /**
     * @param string $token
     * @param array $visited
     *
     * @return array
     */
    protected function getFollowTokens($token, $visited = array())
    {
        $visited[$token] = $token;

        if ($token == self::START_TOKEN) {
            return [self::END_TOKEN];
        }

        $follow = array();

        foreach ($this->right->getRuleSet($token)->getRules() as $rule) {
            $right = $rule->getRight();

            for ($index = 0, $length = count($right); $index < $length; $index++) {
                $rightToken = $right[$index];

                if ($rightToken == $token) {
                    $epsilon = false;
                    if ($index + 1 < $length) {
                        $first = $this->getFirst($right[$index + 1]);
                        $epsilon = isset($first[self::EPSILON_TOKEN]);
                        unset($first[self::EPSILON_TOKEN]);

                        $follow = array_merge($follow, $first);
                    }
                    if ($epsilon || !($index + 1 < $length)) {
                        // avoid cycles
                        if (!isset($visited[$rule->getLeft()])) {
                            $follow = array_merge(
                                $follow, $this->getFollowTokens($rule->getLeft(), $visited)
                            );
                        } elseif ($token != $rule->getLeft()) {
                            // if follow(X) for current X depends on any other
                            // tokens, don't save it - it may be incomplete
                            $save = false;
                        }
                    }
                }
            }

        }

        return $follow;
    }

    /**
     * @param string $token
     * @param array $visited
     *
     * @return array
     */
    protected function getFirst($token, array $visited = array())
    {
        $visited[$token] = $token;

        if ($this->isTerminal($token)) {
            return array($token => $token);
        }

        $first = array();

        foreach ($this->left->getRuleSet($token)->getRules() as $rule) {
            $rights = $rule->getRight();

            if (count($rights) == 1 && $rights[0] == self::EPSILON_TOKEN) {
                return self::EPSILON_TOKEN;
            } else {
                $epsilonCounter = 0;
                foreach ($rights as $right) {
                    // avoid cycles
                    if (isset($visited[$right])) {
                        continue;
                    }

                    $rightFirst = $this->getFirst($right, $visited);
                    $epsilon = isset($rightFirst[self::EPSILON_TOKEN]);
                    unset($rightFirst[self::EPSILON_TOKEN]);

                    // first(Yi)\{epsilon} is in first(X)
                    $first = array_merge($first, $rightFirst);
                    if ($epsilon) {
                        $epsilonCounter++;
                    } else {
                        break;
                    }
                }

                // if epsilon is in first(Yi) for all i, epsilon is in first(X)
                if ($epsilonCounter == count($rights)) {
                    $first[self::EPSILON_TOKEN] = self::EPSILON_TOKEN;
                }
            }
        }

        return $first;
    }

}