<h2>Wgraj plik aby przekonwertować go do base 64</h2>

<form method="POST" action="/base64/convert" enctype="multipart/form-data"  >
    {{csrf_field()}}
    <input type="hidden" name="type" value="code">
    <input type="file" name="fileinput" id="fileinput" />
    <button type="send">Wgraj</button>
</form>

<h2>Wgraj plik aby rozkodować</h2>

<form method="POST" action="/base64/convert" enctype="multipart/form-data"  >
    {{csrf_field()}}
    <input type="hidden"  name="type" value="decode">
    <input type="file" name="fileinput" id="fileinput" />
    <button type="send">Wgraj</button>
</form>

<h2>Pliki zakodowane</h2>
<ul>

@foreach($files as $data)
        @if(($data != "." ) AND ($data !=".."))
        <li><a target="_blank" href="/public/files/{{$data}}">{{$data}}</a></li>
        @endif
@endforeach
</ul>


<h2>Pliki odkodowane</h2>
<ul>

    @foreach($files2 as $data)
        @if(($data != "." ) AND ($data !=".."))
            <li><a target="_blank" href="/public/files_enc/{{$data}}">{{$data}}</a></li>
        @endif
    @endforeach
</ul>