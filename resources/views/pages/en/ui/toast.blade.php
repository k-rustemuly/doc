<x-page title="Toast" :sectionMenu="[
    'Sections' => [
        ['url' => '#basics', 'label' => 'Basics'],
        ['url' => '#without', 'label' => 'Without component'],
    ]
]">
<x-sub-title id="basics">Basics</x-sub-title>

<x-p>
    You can create notifications using the <code>moonshine::toast</code> component.
</x-p>

<x-code language="blade" file="resources/views/examples/components/toast.blade.php"></x-code>

@include('pages.ru.ui.shared.type')

<x-code language="blade" file="resources/views/examples/components/toast-type.blade.php"></x-code>

<div class="flex flex-wrap gap-2">
    @include("examples/components/toast-default")
    @include("examples/components/toast-primary")
    @include("examples/components/toast-secondary")
    @include("examples/components/toast-success")
    @include("examples/components/toast-info")
    @include("examples/components/toast-warning")
    @include("examples/components/toast-error")
</div>

<x-sub-title id="without">Without using a component</x-sub-title>

<x-p>
    You can also create a notification using the <code>MoonShineUi::toast()</code> method.
</x-p>

<x-code language="php">
use MoonShine\MoonShineUI;

MoonShineUI::toast('Toast content', 'error');
</x-code>

</x-page>
