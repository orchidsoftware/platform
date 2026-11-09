<?php

declare(strict_types=1);

use Cosmira\Soda\Config\Soda;
use Cosmira\Soda\Rules\Architecture;
use Cosmira\Soda\Rules\Complexity;
use Cosmira\Soda\Rules\Design;
use Cosmira\Soda\Rules\Documentation;
use Cosmira\Soda\Rules\Naming;
use Cosmira\Soda\Rules\Structure;
use Cosmira\Soda\Rules\Usage;

return Soda::configure()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/database',
        __DIR__.'/routes',
        __DIR__.'/stubs/app',
        __DIR__.'/workbench',
    ])
    ->exclude(['*.blade.php'])
    // Pint owns formatting; descriptions and public signatures remain a review concern.
    // Fluent field APIs and component namespaces are not capped by method or class counts.
    ->with([
        new Design\FragmentedOwnerBehavior(minClasses: 3),
        new Design\RepeatedConfigurationSequence(minOccurrences: 3, minConfigurationCalls: 2),
        new Design\RepeatedForeignStateDecision(minConsumers: 3),
        new Design\RepeatedForeignStateUpdate(minConsumers: 3),
        new Design\RepeatedOwnerConcern(minMethods: 3, minOwners: 2),
        new Design\RepresentationChurn(),
        new Design\ScatteredOwnerConcern(minMethods: 3),
        new Documentation\NoConsecutiveBlockComments(),
        new Structure\MaxClassLength(500),
        new Structure\MaxClassesPerFile(1),
        new Structure\MaxDelegationDepth(3),
        new Structure\MaxDependencies(8),
        new Structure\MaxEffectiveClassLength(500),
        new Structure\MaxEffectiveMethodsPerClass(40),
        // Laravel providers, base screen types and composed example screens wire many collaborators.
        (new Structure\MaxEfferentCoupling(15))->exclude([
            __DIR__.'/src/Platform/Models/User.php',
            __DIR__.'/src/Platform/Providers',
            __DIR__.'/src/Screen/LayoutFactory.php',
            __DIR__.'/src/Screen/Screen.php',
            __DIR__.'/stubs/app/Orchid/Screens',
        ]),
        new Structure\MaxFileLoc(700),
        new Structure\MaxInterfacesPerClass(5),
        new Structure\MaxLayerDominancePercentage(50, 4),
        // Example catalogs show field configuration together in a single screen.
        (new Structure\MaxMethodLength(100))->exclude([
            __DIR__.'/stubs/app/Orchid/Screens/Examples/ExampleFieldsScreen.php',
            __DIR__.'/stubs/app/Orchid/Screens/Examples/ExampleFieldsAdvancedScreen.php',
        ]),
        new Structure\MaxMethodsPerClass(40),
        new Structure\MaxTraitsPerClass(10),
        new Structure\MethodsFollowCallOrder(),
        // Reflection inspects attributes; service providers conditionally register console services.
        (new Structure\NoAskThenTellPatterns())->exclude([
            __DIR__.'/src/Platform/Orchid.php',
            __DIR__.'/src/Platform/Providers/FoundationServiceProvider.php',
        ]),
        new Structure\NoCommentedOutCode(),
        new Structure\NoEmptyCatchBlocks(),
        new Structure\NoTodoFixmeComments(),
        new Structure\NoTrivialDelegatingClasses(),
        // Layout factories use anonymous subclasses to expose the fluent layout API.
        (new Architecture\NoAnonymousClasses())->exclude([
            __DIR__.'/src/Screen/LayoutFactory.php',
        ]),
        new Architecture\NoBlockingSleep(),
        new Architecture\NoCatchAllExceptions(),
        new Architecture\NoClosureRebinding(),
        new Architecture\NoDirectFilesystemMutation(),
        // Turbo sets a fallback status before dd() or die() can terminate the request.
        (new Architecture\NoDirectResponseGlobals())->exclude([
            __DIR__.'/src/Platform/Http/Middleware/Turbo.php',
        ]),
        // These extension points deliberately dispatch presenter, macro, enum and Eloquent scope names.
        (new Architecture\NoDynamicInvocation())->exclude([
            __DIR__.'/src/Presenter/Presenter.php',
            __DIR__.'/src/Screen/Field.php',
            __DIR__.'/src/Screen/Fields/Select.php',
            __DIR__.'/src/Screen/Fields/Support/ChoicePayload.php',
            __DIR__.'/src/Support/Testing/DynamicTestScreen.php',
        ]),
        new Architecture\NoDynamicProperties(),
        // TD uses this public marker to distinguish fields accepting array filter values.
        (new Architecture\NoEmptyLocalInterfaces())->exclude([
            __DIR__.'/src/Screen/Concerns/ComplexFieldConcern.php',
        ]),
        new Architecture\NoEnvironmentReads(),
        new Architecture\NoErrorSuppression(),
        new Architecture\NoGlobalState(),
        new Architecture\NoImplicitArguments(),
        // Filter and chart option names are input data validated against their supported types.
        (new Architecture\NoModeParameters())->exclude([
            __DIR__.'/src/Screen/TD.php',
            __DIR__.'/src/Screen/Layouts/Chart.php',
        ]),
        new Architecture\NoNativeDeserialization(),
        new Architecture\NoProcessConfigurationMutation(),
        new Architecture\NoRedundantLocalInterfaces(),
        new Architecture\NoRepeatedTypeDispatch(minMethods: 2),
        new Architecture\NoRuntimeCodeEvaluation(),
        new Architecture\NoRuntimeHooks(),
        new Architecture\NoRuntimeIncludes(),
        new Architecture\NoRuntimeTypeAliases(),
        new Architecture\NoSingletonAccess(),
        new Architecture\NoSubprocessExecution(),
        new Architecture\NoSymbolTableMutation(),
        new Usage\NoNumericArrayIndex(),
        new Usage\NoTemporaryReturnVariable(),
        new Usage\NoUnusedMethods(),
        new Usage\NoUnusedPrivateState(),
        // Nested layout results intentionally group rendered children under their parent key.
        (new Usage\OnlyListArraysAllowed())->exclude([
            __DIR__.'/src/Screen/Layout.php',
        ]),
        new Usage\PreferIncludes(),
        new Usage\PreferStringStartsEndsWith(),
        new Usage\UselessVariableRule(),
        new Complexity\MaxBooleanConditions(4),
        new Complexity\MaxCognitiveComplexity(15),
        new Complexity\MaxConsecutiveLocalAssignments(8),
        new Complexity\MaxControlNesting(3),
        // An exhaustive enum mapping has one branch for each supported color.
        (new Complexity\MaxCyclomaticComplexity(8))->exclude([
            __DIR__.'/src/Support/Color.php',
        ]),
        new Complexity\MaxStatementsPerCallable(20),
        new Complexity\MaxTryCatchBlocks(2),
        new Complexity\NoAssignmentInCondition(),
        new Complexity\NoAssignmentInReturn(),
        new Complexity\NoChainedAssignments(),
        new Complexity\NoComplexControlConditions(),
        new Complexity\NoDeclarationsBeforeEarlyExit(),
        new Complexity\NoElseBranches(),
        new Complexity\NoEmptyFinallyBlocks(),
        new Complexity\NoIdenticalBranches(),
        new Complexity\NoNestedTernary(),
        new Complexity\NoRepeatedCompoundConditions(minMethods: 3),
        new Complexity\NoReturnInFinally(),
        new Complexity\NoUnneededTernary(),
        new Complexity\PreferContinue(),
        new Complexity\PreferNullCoalesceAssignment(),
        new Naming\AvoidRedundantNaming(80),
        new Naming\MethodNameLength(min: 1, max: 40),
        new Naming\NamespaceNameLength(min: 3, max: 32),
        new Naming\VariableNameLength(min: 1, max: 30),
    ]);
