<table class="table table-bordered table-striped table-hover display nowrap">
    <thead>
        <tr>
            <th style="width: 80px">Nome</th>
            <th>Email</th>
            <th style="width: 120px; min-width: 120px">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($destinations as $destination)
            <tr>
                <td>#{!! str_pad($destination->id, 4, "0", STR_PAD_LEFT) !!}</td>
                <td>{!! $destination->name !!}</td>
                <td>
                    {!! Form::open([
                        'route' => ['destinations.destroy', $destination->id],
                        'method' => 'delete'
                    ]) !!}
                    @shield('destination.show')
                        <a href="{!! route('destinations.show', [$destination->id]) !!}">
                            <i class="fa fa-cogs icon-rounded icon-xs icon-info"></i>
                        </a>
                    @endshield
                    @shield('destination.edit')
                        <a href="{!! route('destinations.edit', [$destination->id]) !!}">
                            <i class="fa fa-pencil icon-rounded icon-xs icon-warning"></i>
                        </a>
                    @endshield
                    @shield('destination.delete')
                    {!! Form::button(
                        '<i
                            class="glyphicon glyphicon-remove icon-rounded icon-xs icon-danger"
                        ></i>', [
                        'type' => 'submit',
                        'style' => 'padding: 0; margin: 0; border: 0;',
                        'onclick' => "return confirm('Deseja realmente remover esse registro?')"
                        ])
                    !!}
                    @endshield
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
