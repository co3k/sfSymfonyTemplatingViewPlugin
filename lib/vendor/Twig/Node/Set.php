<?php

class Twig_Node_Set extends Twig_Node
{
  protected $names;
  protected $values;
  protected $isMultitarget;

  public function __construct($isMultitarget, $names, $values, $lineno, $tag = null)
  {
    parent::__construct($lineno, $tag);

    $this->isMultitarget = $isMultitarget;
    $this->names = $names;
    $this->values = $values;
  }

  public function __toString()
  {
    $repr = array(get_class($this).'('.($this->isMultitarget ? implode(', ', $this->names) : $this->names).',');
    foreach ($this->isMultitarget ? $this->values : array($this->values) as $node)
    {
      foreach (explode("\n", $node->__toString()) as $line)
      {
        $repr[] = '  '.$line;
      }
    }
    $repr[] = ')';

    return implode("\n", $repr);
  }

  public function compile($compiler)
  {
    $compiler->addDebugInfo($this);

    if ($this->isMultitarget)
    {
      $compiler->write('list(');
      foreach ($this->names as $idx => $node)
      {
        if ($idx)
        {
          $compiler->raw(', ');
        }

        $compiler
          ->raw('$context[')
          ->string($node->getName())
          ->raw(']')
        ;
      }
      $compiler->raw(')');
    }
    else
    {
      $compiler
        ->write('$context[')
        ->string($this->names->getName())
        ->raw(']')
      ;
    }

    $compiler->raw(' = ');

    if ($this->isMultitarget)
    {
      $compiler->write('array(');
      foreach ($this->values as $idx => $value)
      {
        if ($idx)
        {
          $compiler->raw(', ');
        }

        $compiler->subcompile($value);
      }
      $compiler->raw(')');
    }
    else
    {
      $compiler->subcompile($this->values);
    }

    $compiler->raw(";\n");
  }
}
