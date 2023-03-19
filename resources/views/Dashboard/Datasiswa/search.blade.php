@foreach ($data as $item)
<tr>
    <td>{{ $item->nisn }}</td>
    <td>{{ $item->nis }}</td>
    <td>{{ $item->nama }}</td>
    <td>{{ $item->kelas->nama_kelas.'-'.$item->kelas->kompetensi_keahlian }}</td>
    <td>{{ $item->alamat }}</td>
    <td>{{ $item->no_telp }}</td>
    <td>
        <div class="wrapper-action">
            <a href="/dashboard/data-siswa/detail/{{ $item->nisn }}">
                <i title="Detail" style="color: rgb(0, 119, 255);" class="fa-solid fa-eye"></i>
            </a>
            <i attr-data-string="{{ json_encode($item) }}" title="Edit" style="color:orange;" class="fa-solid fa-pen-to-square button-edit"></i>
            <i title="Delete" attr-nisn="{{ $item->nisn }}" style="color:red;" class="fa-solid fa-trash button-delete"></i>
        </div>
    </td>
</tr>
@endforeach