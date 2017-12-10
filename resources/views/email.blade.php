<h1>Wyślij wiadomość</h1>
<form method="POST" action="/send_email">
    {{csrf_field()}}
    <input id="email" name="email" placeholder="email">
    <input id="temat" name="temat" placeholder="temat">
    <input id="treść" name="tresc" placeholder="treść">

    <button type="submit">Wyślij</button>
</form>


<hr>
<h1>Tytuł najnowszej Wiadomości:</h1>

<p>{{$mailbox->subject}}</p>

<script>
    setTimeout(function(){ location.reload() }, 9000);

</script>