<?php

declare(strict_types=1);

namespace Drupal\audit\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the ReportLengthConstraint constraint.
 */
final class ReportLengthConstraintConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate(mixed $value, Constraint $constraint): void {
    // @todo Validate the value here.
    if ( strlen($value) < 15 ) {
      $this->context->addViolation($constraint->message);
    }
  }

}
