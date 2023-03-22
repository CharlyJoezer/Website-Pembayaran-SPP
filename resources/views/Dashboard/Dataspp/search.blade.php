@foreach ($data as $item)
<tr>
    <td>{{ $item->tahun }}</td>
    <td>{{ number_format($item->nominal,0,'.','.') }}</td>
    <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td>
    <td>
        <div class="wrapper-action">
            {{-- <a href="/dashboard/data-kelas/detail/{{ $item->id_kelas }}">
                <i title="Detail" style="color: rgb(0, 119, 255);" class="fa-solid fa-eye"></i>
            </a> --}}
            <i attr-data-string="{{ json_encode($item) }}" title="Edit" style="color:orange;" class="fa-solid fa-pen-to-square button-edit"></i>
            <i title="Delete" attr-id="{{ $item->id_spp }}" style="color:red;" class="fa-solid fa-trash button-delete"></i>
        </div>
    </td>
</tr>
@endforeach