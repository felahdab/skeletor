# Project instructions

## Technology

* Laravel 13
* PHP 8.4
* Filament 5
* Pest
* Nwidart Laravel Modules
* MariaDB
* Redis

## Architecture

This is an existing application. Preserve its architecture and conventions.

Before implementing a feature:

* Inspect existing implementations of similar features.
* Reuse existing patterns and abstractions.
* Do not introduce a new architectural pattern when an existing one is suitable.
* Do not modify unrelated modules or infrastructure.

Modules are independently structured provide the business logic. 
The application layer is responsible for orchestrating the business logic and providing a public interface to the module only.
Do not modify the base application unless explicitly requested.

## Filament

* This project uses Filament 5.
* Never use Filament 4 APIs or examples.
* Prefer native Filament components, actions, forms, tables and resources.
* Do not create custom Livewire components when native Filament functionality is sufficient.
* Do not introduce JavaScript when the behaviour can be implemented using Filament/PHP.
* Keep business/domain logic outside Filament components when appropriate.
* Follow the conventions used by existing Resources, Pages, Forms, Tables and Actions.
* Report if you detect unconsistent usage of Filament APIs among the already existing code. Do not modify unless explicitly requested.

Before using an unfamiliar Filament API:

* Inspect the installed Filament source/vendor code.
* Check existing usages in this repository.
* Do not rely solely on remembered Filament APIs.

If the user wants to implement a calendar display of the data, refer to the guava/calendar projet documentation (https://github.com/GuavaCZ/calendar). Do not implement a custom calendar component unless explicitly requested.

## Testing

Use Pest.

When adding or modifying functionality:

* Add tests for important behaviour.
* Test authorization and visibility of Filament actions.
* Test form validation and submission.
* Test database state where appropriate.
* Prefer Filament's native testing utilities over testing implementation details.

Run the relevant tests after making changes.

## Coding style

* Follow existing PHP conventions.
* Use strict typing where the project already does so.
* Keep methods focused and small.
* Avoid unnecessary abstractions.
* Do not add dependencies unless explicitly requested.

## Changes

Before editing:

1. Inspect the relevant existing code.
2. Identify the closest existing implementation.
3. Explain briefly what you intend to change.

After editing:

1. Review the diff.
2. Run relevant tests.
3. Fix failures.
4. Report the files changed and tests executed.

If a requirement is ambiguous, make the smallest reasonable assumption and state it.
