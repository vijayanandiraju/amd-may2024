<?php

declare(strict_types=1);

namespace Drupal\audit\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Provides a ReportLengthConstraint constraint.
 *
 * @Constraint(
 *   id = "AuditReportLengthConstraint",
 *   label = @Translation("ReportLengthConstraint", context = "Validation"),
 * )
 */
final class ReportLengthConstraintConstraint extends Constraint {

  public string $constraint_display_message = 'Report length less than 15 characters.';

}
