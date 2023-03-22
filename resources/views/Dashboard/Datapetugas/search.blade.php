@foreach ($data as $item)
<tr>
    <td>{{ $item->username }}</td>
    <td>{{ $item->nama_petugas }}</td>
    <td>{{ $item->level }}</td>
    <td>
        <div class="wrapper-action">
            <a href="/dashboard/data-petugas/detail/{{ $item->id_petugas }}">
                <i title="Detail" style="color: rgb(0, 119, 255);" class="fa-solid fa-eye"></i>
            </a>
            <i attr-data-string="{{ json_encode($item) }}" title="Edit" style="color:orange;" class="fa-solid fa-pen-to-square button-edit"></i>
            <i title="Delete" attr-id="{{ $item->id_petugas }}" style="color:red;" class="fa-solid fa-trash button-delete"></i>
        </div>
    </td>
</tr>
@endforeach