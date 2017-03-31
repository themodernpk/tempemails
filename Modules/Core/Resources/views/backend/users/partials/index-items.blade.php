
<table class="table"
       data-plugin="selectable" data-row-selectable="true">
    <thead>
    <tr>
        <th class="w-50">
<span class="checkbox-custom checkbox-primary">
<input class="selectable-all" type="checkbox"><label></label>
</span>
        </th>
        <th class="hidden-sm-down">#</th>
        <th>Name</th>
        <th>Email/Mobile</th>
        <th>Enable</th>
        <th class="hidden-sm-down">Roles</th>
        <th class="hidden-sm-down" width="150">Actions</th>
    </tr>
    </thead>
    <tbody >

    @foreach($data['list'] as $item)
        <tr>
            <td >
                <span class="checkbox-custom checkbox-primary">
                            <input class="selectable-item" type="checkbox"
                                   value="{{$item->id}}">
                            <label for="row-{{$item->id}}"></label>
                          </span></td>
            <td class="hidden-sm-down">{{$item->id}}</td>
            <td>{{$item->name}}
                @if($item->deleted_at)
                    <span class="tag tag-danger">Deleted</span>
                @endif
            </td>
            <td>{{$item->email}}
            <br/> {{$item->mobile}}
            </td>
            <td>
                @if($item->enable == 0)
                    <a href="{{route('core.backend.users.enable', [$item->id])}}"
                       class="btn btn-xs btn-href btn-danger enableToggle ">No</a>
                @else
                    <a href="{{route('core.backend.users.disable', [$item->id])}}"
                    class="btn btn-xs btn-href btn-success enableToggle ">Yes</a>
                @endif
            </td>
            <td class="hidden-sm-down">
                @if($item->roles)
                    @foreach($item->roles as $role)
                        <a href="{{route('core.backend.roles.read', [$role->id])}}"
                           target="_blank">{{$role->name}}</a>,
                    @endforeach
                @endif
            </td>
            <td class="hidden-sm-down">
                <a href="{{route('core.backend.users.view', [$item->id])}}"
                   target="_blank"
                   class="btn btn-sm btn-icon btn-flat btn-default">
                    <i class="icon wb-eye" aria-hidden="true"></i>
                </a>

                <a href="{{route('core.backend.users.edit', [$item->id])}}"
                   target="_blank"
                   class="btn btn-sm btn-icon btn-flat btn-default">
                    <i class="icon wb-pencil" aria-hidden="true"></i>
                </a>

                <a href="{{route('core.backend.users.delete', [$item->id])}}"
                   class="btn btn-sm btn-icon btn-flat btn-default itemDelete">
                    <i class="icon wb-trash" aria-hidden="true"></i>
                </a>

            </td>
        </tr>
                    <a
    @endforeach



    </tbody>
</table>
