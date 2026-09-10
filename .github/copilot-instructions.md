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

# Module repository model

This application is modular.

The `Modules/` directory contains independently developed modules.

**Each directory directly under `Modules/` is a separate Git repository.**

For example:

```text
Modules/
├── ModuleA/    # independent Git repository
├── ModuleB/    # independent Git repository
└── ModuleC/    # independent Git repository
```

These repositories are NOT Git submodules of the main application repository.

They are cloned into `Modules/` on an as-needed basis.

The main application repository does not track the contents of the module repositories as Git submodules.

The main application must not depend on any module. Never introduce a dependency on a module in the main application.

Modules are loaded dynamically at runtime via the Nwidart package. The main application does not need to know which modules are present.

## Working across repository boundaries

When a task involves functionality implemented by a module:

1. Identify which module owns the relevant functionality.
2. Inspect the module's source code before making assumptions.
3. Treat the module as an independent repository.
4. Inspect the module's own Git status, history, branches and repository structure when relevant.
5. Do not assume that changes inside `Modules/<ModuleName>` belong to the main application's Git repository.
6. Do not create Git submodules.
7. Do not modify Git configuration to make a module a submodule.
8. Do not commit module changes as part of the main application repository.
9. If changes are required in both the application and a module, treat them as two separate changesets/repositories.

The fact that the module directory is physically located below the main application's directory does NOT mean that the module belongs to the main application's Git repository.

## Always inspect the module when appropriate

Do not rely solely on the main application's references to a module.

If a task concerns:

* a Filament Resource defined in a module
* a model defined in a module
* a service/action defined in a module
* a migration defined in a module
* a module-specific configuration
* module-specific tests
* module-specific frontend assets
* a module-specific dependency

inspect the corresponding module repository.

For example, if the task concerns:

```text
Modules/Foo/app/Filament/Resources/BarResource.php
```

inspect the `Modules/Foo` repository and its surrounding code before modifying the Resource.

## Determine repository ownership

When operating on a file under `Modules/`, determine the Git repository that owns the file.

Do not assume that the nearest VS Code workspace root is the repository root.

The repository boundary can be identified from the presence of the module's own `.git` directory or Git metadata.

When useful, run Git commands from inside the module directory, for example:

```bash
git -C Modules/Foo status
git -C Modules/Foo branch --show-current
git -C Modules/Foo log -n 10 --oneline
```

Use the appropriate repository when inspecting history or reviewing changes.

## Cross-repository changes

Some application features span the main application and one or more modules.

For example:

```text
Main application
    ↓
Module
    ↓
Filament Resource
```

When a change crosses repository boundaries:

1. Identify all affected repositories.
2. Inspect each repository independently.
3. Make changes in the appropriate repository.
4. Test each repository using its own conventions where applicable.
5. Keep Git changes separate.
6. Clearly report which files belong to which repository.

Never hide a cross-repository change by treating all files as belonging to the main repository.

## Git operations

Before performing Git operations, determine which repository the operation should apply to.

For a module:

```bash
git -C Modules/<ModuleName> ...
```

For the main application:

```bash
git ...
```

Do not run destructive Git commands.

Do not reset, checkout, rebase, force-push, delete branches, or discard changes without explicit user instruction.

Before committing, verify the repository being committed to.

## Module dependencies

The presence of a module in the filesystem is therefore part of the local development environment, even though the module is maintained in a separate Git repository.

Do not remove or replace a module merely because it is not tracked by the main application's Git repository.

Do not assume every module is present.

If a requested feature references a module that is not currently available locally, report that fact and determine whether the task can be completed without it.

## Module conventions

Each module may have its own:

* architecture
* tests
* Filament Resources
* services/actions
* models
* configuration
* dependencies
* documentation
* coding conventions

When modifying a module, inspect its existing implementation and follow its conventions.

Do not impose application-level conventions on a module if the module already has a clearly established local convention.

The main application's architectural rules still apply where they explicitly govern the module integration.

## Completion reporting

When a task involves multiple repositories, report changes grouped by repository.

For example:

```text
Main application:
- changed config/...
- changed app/...

Module Foo:
- changed app/Filament/...
- changed tests/...

Module Bar:
- no changes
```

Also report tests and validation commands executed for each affected repository.


## Testing

The host system must not be used to run php for linting or testing. A docker compose stack if defined in the docker subdirectory. Use this stack to run php commands. Check if the stack is already running or start it. When the stack is started, the application folder is already mounted into the /app folder. Do not use docker run commands but use docker compose exec instead. For exemple, to run php artisan commands, use:

```bash
docker compose exec php php artisan ...
```


Use Pest.

When adding or modifying functionality:

* Add tests for important behaviour.
* Test authorization and visibility of Filament actions.
* Test form validation and submission.
* Test database state where appropriate.
* Prefer Filament's native testing utilities over testing implementation details.

Run the relevant tests after making changes.

To run the tests of the main application, use the Skeletor pest group.
To run the tests of a module, use the module pest group name. By default, the module pest group name is the module name. For example, to run the tests of the Foo module, use the Foo pest group.

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

## Repository access

The user explicitly authorizes Copilot to read and modify all repositories under `Modules/`.

These are independent Git repositories, not read-only dependencies.

When a task requires changes to a module, freely inspect and modify that module repository just as you would the main application repository.

Always determine the correct Git repository before running Git commands.

Do not refuse or stop merely because `Modules/<ModuleName>` is a separate Git repository.

Protect existing uncommitted work and do not perform destructive Git operations without explicit user authorization.