<x-p>
    The <code>icon()</code> method allows you to add an icon to the metric.
</x-p>

<x-code language="php">
use MoonShine\Metrics\ValueMetric;

//...

public function components(): array
{
    return [
        ValueMetric::make('Orders')
            ->value(Order::count())
            ->icon('heroicons.shopping-bag') // [tl! focus]
    ];
}

//...
</x-code>

<x-moonshine::alert type="default" icon="heroicons.book-open">
    For more detailed information, please refer to the section
    <x-link link="{{ route('moonshine.page', 'icons') }}">Icons</x-link>.
</x-moonshine::alert>


<x-image theme="light" src="{{ asset('screenshots/' . str($metric)->snake('_')->append('_icon.png')) }}"></x-image>
<x-image theme="dark" src="{{ asset('screenshots/' . str($metric)->snake('_')->append('_icon_dark.png')) }}"></x-image>
