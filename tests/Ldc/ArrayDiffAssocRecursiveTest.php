<?php
namespace LdcTest;

class ArrayDiffAssocRecursiveTest extends \PHPUnit_Framework_TestCase
{
    public function testRequiresArraysAsFirstArgument()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        \Ldc\array_diff_assoc_recursive('foo', []);
    }

    public function testRequiresArraysAsSecondArgument()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        \Ldc\array_diff_assoc_recursive([], 'foo');
    }

    /**
     * @dataProvider providerScenarios
     */
    public function testScenarios($a, $b, $expected)
    {
        $this->assertEquals(
            $expected,
            \Ldc\array_diff_assoc_recursive($a, $b)
        );
    }

    public function providerScenarios()
    {
        return [
            'Root key in A but not in B' => [
                'a' => [
                    'foo' => [
                        'bar' => 'baz',
                    ],
                ],
                'b' => [
                ],
                'expected' => [
                    'foo' => [
                        'bar' => 'baz',
                    ],
                ],
            ],
            'Root key in B but not in A' => [
                'a' => [
                ],
                'b' => [
                    'foo' => [
                        'bar' => 'baz',
                    ],
                ],
                'expected' => [
                    'foo' => [
                        'bar' => 'baz',
                    ],
                ],
            ],
            'Subkey in A but not in B' => [
                'a' => [
                    'foo' => [
                        'bar' => [
                            'baz' => 'bat',
                        ],
                    ],
                ],
                'b' => [
                    'foo' => [
                        'bar' => [],
                    ],
                ],
                'expected' => [
                    'foo' => [
                        'bar' => [
                            'baz' => 'bat',
                        ],
                    ],
                ],
            ],
            'Subkey in B but not in A' => [
                'a' => [
                    'foo' => [
                        'bar' => [],
                    ],
                ],
                'b' => [
                    'foo' => [
                        'bar' => [
                            'baz' => 'bat',
                        ],
                    ],
                ],
                'expected' => [
                    'foo' => [
                        'bar' => [
                            'baz' => 'bat',
                        ],
                    ],
                ],
            ],
            'Subkey in A and B have different scalar values' => [
                'a' => [
                    'foo' => [
                        'bar' => [
                            'baz' => 'bat',
                        ],
                    ],
                ],
                'b' => [
                    'foo' => [
                        'bar' => [
                            'baz' => 'tab',
                        ],
                    ],
                ],
                'expected' => [
                    'foo' => [
                        'bar' => [
                            'baz' => ['bat','tab'],
                        ],
                    ],
                ],
            ],
            'Subkey in A is an array but a scalar in B' => [
                'a' => [
                    'foo' => [
                        'bar' => [
                            'baz' => 'bat',
                        ],
                    ],
                ],
                'b' => [
                    'foo' => [
                        'bar' => 'bat',
                    ],
                ],
                'expected' => [
                    'foo' => [
                        'bar' => [
                            ['baz' => 'bat'],
                            'bat',
                        ],
                    ],
                ],
            ],
            'Same aubkey in A and B have numerically-indexed arrays' => [
                'a' => [
                    'foo' => [
                        'bar' => [
                            'baz',
                            'bat',
                        ],
                    ],
                ],
                'b' => [
                    'foo' => [
                        'bar' => [
                            'baz',
                            'bat',
                            'tab',
                        ],
                    ],
                ],
                'expected' => [
                    'foo' => [
                        'bar' => [
                            2 => 'tab',
                        ],
                    ],
                ],
            ],
        ];
    }
}
