@php use MoonShine\Fields\Text; @endphp
<x-page
    title="TableBuilder"
    :sectionMenu="[
        'Разделы' => [
            ['url' => '#basics', 'label' => 'Основы'],
            ['url' => '#methods', 'label' => 'Методы'],
        ]
    ]"
>

<x-sub-title id="basics">Основы</x-sub-title>

<x-p>
    Поля и декорации в MoonShine используются внутри таблиц в режиме <code>preview</code>. За таблицы отвечает TableBuilder.
    Благодаря TableBuilder таблицы отображаются и наполняются данными.
    Вы также можете использовать TableBuilder на собственных страницах или даже вне MoonShine.
</x-p>

<x-code language="php">
make(
    Fields|array $fields = [],
    protected iterable $items = [],
    protected ?Paginator $paginator = null
)
</x-code>

<x-ul>
    <li><code>fields</code> - поля,</li>
    <li><code>items</code> - значения полей,</li>
    <li><code>paginator</code> - объект пагинатора.</li>
</x-ul>

<x-code language="php">
TableBuilder::make([Text::make('Text')], [['text' => 'Value']])
</x-code>

<x-p>
    Тоже самое через методы:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->fields([
        Text::make('Text')
    ])
    ->items([['text' => 'Value']])
</x-code>

<x-p>
    Также доступен helper:
</x-p>

<x-code language="php">
@{!! table()
    ->fields([
        Text::make('Text')
    ])
    ->items([
        ['text' => 'Value']
    ])
!!}
</x-code>

{!!
    table()
        ->fields([
            Text::make('Text')
        ])
        ->items([
            ['text' => 'Value']
        ])
!!}

<x-sub-title id="methods">Методы</x-sub-title>

<x-moonshine::divider label="fields" />

<x-p>
    Метод <code>fields</code> для объявления полей:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->fields([
        Text::make('Text'),
    ])
</x-code>

<x-moonshine::divider label="items/paginator" />

<x-p>
    Метод <code>items</code> для наполнения таблицы данными:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->fields([
        Text::make('Text'),
    ])
    ->items([['text' => 'Value']])
</x-code>

<x-p>
    Метод <code>paginator</code> для того чтобы таблица работала с пагинацией:
</x-p>

<x-code language="php">
$paginator = Article::paginate();

TableBuilder::make()
    ->fields([
        Text::make('Text'),
    ])
    ->items($paginator->items())
    ->paginator($paginator)

// or simple

TableBuilder::make(items: Article::paginate())
    ->fields([
        Text::make('Text'),
    ])
</x-code>

<x-moonshine::divider label="cast" />

<x-p>
    Метод <code>cast</code> для приведения значений таблицы к определенному типу.
    Так как по умолчанию поля работают с примитивными типами:
</x-p>

<x-code language="php">
use MoonShine\TypeCasts\ModelCast;

TableBuilder::make(items: User::paginate())
    ->fields([
        Text::make('Email'),
    ])
    ->cast(ModelCast::make(User::class))
</x-code>

<x-p>
    В этом примере мы привели данные к формату модели <code>User</code> с использованием <code>ModelCast</code>.
</x-p>

<x-p>
    <x-moonshine::alert type="default" icon="heroicons.book-open">
        Подробнее о TypeCasts читайте в одноименном разделе.
    </x-moonshine::alert>
</x-p>

<x-moonshine::divider label="buttons" />
<x-p>
    Для добавления новых кнопок на основе <code>ActionButton</code>, воспользуйтесь методом <code>buttons</code>.
    Кнопки будут добавляться для каждого row, а при включении режима bulk отображаться в футере для массовых действий:
</x-p>

<x-code language="php">
TableBuilder::make(items: Article::paginate())
    ->fields([ID::make(), Switcher::make('Active')])
    ->cast(ModelCast::make(Article::class))
    ->buttons([
        ActionButton::make('Delete', route('name.delete')),
        ActionButton::make('Edit', route('name.edit'))->showInDropdown(),
        ActionButton::make('Go to home', route('home'))->blank()->canSee(fn($data) => $data->active),
        ActionButton::make('Mass Delete', route('name.mass_delete'))->bulk()
    ])
</x-code>

<x-moonshine::divider label="async" />

<x-p>
    Если необходимо получать данные из таблицы асинхронно (при пагинации, сортировке), то воспользуйтесь методом <code>async</code>:
</x-p>

<x-code language="php">
TableBuilder::make()
    ->async('/async_url')
</x-code>

<x-moonshine::divider label="Attributes" />

<x-p>
    Вы можете задать любые html атрибуты для таблицы через метод <code>customAttributes</code>:
</x-p>

<x-code>
TableBuilder::make()->customAttributes(['class' => 'custom-form']),
</x-code>

<x-p>
    Вы можете задать любые html атрибуты для строк и ячеек таблицы:
</x-p>

<x-code>
TableBuilder::make()->trAttributes(function(mixed $data, int $row, ComponentAttributeBag $attributes): ComponentAttributeBag {
    return $attributes->merge(['class' => 'bgc-green']);
}),
</x-code>

{!!
    table()
        ->simple()
        ->fields([
            Text::make('Text')
        ])
        ->items([
            ['text' => 'Value']
        ])->trAttributes(function(mixed $data, int $row, $attributes) {
            return $attributes->merge(['class' => 'bgc-green']);
        })
!!}

<x-code>
TableBuilder::make()->tdAttributes(function(mixed $data, int $row, int $cell, ComponentAttributeBag $attributes): ComponentAttributeBag {
    return $attributes->merge(['class' => 'bgc-red']);
}),
</x-code>

{!!
    table()
        ->simple()
        ->fields([
            Text::make('Text')
        ])
        ->items([
            ['text' => 'Value']
        ])->trAttributes(function(mixed $data, int $row, $attributes) {
            return $attributes->merge(['class' => 'bgc-red']);
        })
!!}

<x-moonshine::divider label="withNotFound" />

<x-p>
    По умолчанию, если у таблицы нет данных, то она будет пустой, но можно вывести сообщение "Пока записей нет".
    Для этого воспользуйтесь методом <code>withNotFound</code>:
</x-p>

<x-code>
TableBuilder::make()->withNotFound(),
</x-code>

{!!
    table()
        ->fields([
            Text::make('Text')
        ])->withNotFound()
!!}

<x-moonshine::divider label="simple" />

<x-p>
    По умолчанию таблица стилизована под MoonShine, но с помощью метода <code>simple</code> можно отобразить таблицу в упрощённом стиле:
</x-p>

<x-code>
TableBuilder::make()->simple(),
</x-code>

{!!
    table()
        ->simple()
        ->fields([
            Text::make('Text')
        ])->items([['text' => 'Value']])
!!}

<x-moonshine::divider label="preview" />

<x-p>
    Метод <code>preview</code> отключает отображение кнопок и сортировок для таблицы:
</x-p>

<x-code>
TableBuilder::make()->preview(),
</x-code>

<x-moonshine::divider label="vertical" />

<x-p>
    С помощью метода <code>vertical</code> можно отобразить таблицу в вертикальном режиме:
</x-p>

<x-code>
TableBuilder::make()->vertical(),
</x-code>

{!!
    table()
        //->vertical() broken in alpha3, all done in repo
        ->fields([
            Text::make('Text'),
            Text::make('Text 2')
        ])->items([['text' => 'Value']])
!!}

<x-moonshine::divider label="creatable/reindex" />

<x-p>
    С помощью метода <code>creatable()</code> можно создать кнопку "Добавить" для генерации новых записей в таблице:
</x-p>

<x-code language="php">
TableBuilder::make()->creatable(),
</x-code>

<x-p>
    Если в таблице находятся поля в режиме редактирования с динамическим name,
    то нужно добавить метод или параметр <code>reindex</code>:
</x-p>

<x-code>
    TableBuilder::make()->creatable(reindex: true),
    // or
    TableBuilder::make()->creatable()->reindex(),
</x-code>

<x-p>
    Если требуется ограничить количество записей которые можно добавить, то необходимо указать параметр <code>limit</code>:
</x-p>

<x-code>
    TableBuilder::make()->creatable(limit: 6),
</x-code>

{!!
    table()
        ->creatable()
        ->fields([
            Text::make('Text'),
            Text::make('Text 2')
        ])->items([['text' => 'Value']])
!!}

<x-moonshine::divider label="editable" />

<x-p>
    По умолчанию поля в таблице отображаются в режиме <code>preview()</code>,
    но если требуется отобразить их как элементы формы с возможностью редактирования,
    то необходимо воспользоваться методом <code>editable()</code>:
</x-p>

<x-code>
TableBuilder::make()->editable(),
</x-code>

{!!
    table(items: [['text' => 'Value', 'field' => 'Value'], ['text' => '', 'field' => '']])
        ->creatable()->reindex()->editable()
        ->fields([
            Text::make('Text'),
            Text::make('Field')
        ])
!!}

<x-p>
    <x-moonshine::alert type="default" icon="heroicons.book-open">
        В режиме добавления необходимо, чтобы последний элемент был пустым (скелет новой записи):
    </x-moonshine::alert>
</x-p>

<x-moonshine::divider label="sortable" />

<x-p>
    Для сортировки строк в таблице воспользуйтесь методом <code>sortable()</code>:
</x-p>

<x-code language="php">
sortable(
    ?string $url = null,
    string $key = 'id',
    ?string $group = null
)
</x-code>

<x-ul>
    <li><code>url</code> - url-обработчика,</li>
    <li><code>key</code> - ключ элемента,</li>
    <li><code>group</code> - группировка.</li>
</x-ul>

<x-code language="php">
TableBuilder::make()
    ->sortable(url: '/update_indexes_endpoint', key: 'id', group: 'nested'),
</x-code>

{!!
    table(items: [['text' => 'Value 1', 'field' => 'Value 1'], ['text' => 'Value 2', 'field' => 'Value 2']])
        ->sortable()
        ->fields([
            Text::make('Text'),
            Text::make('Field')
        ])
!!}

</x-page>
