<div class="bg-red-500 p-5">
    <h1>Home Page</h1>

    @foreach ($test as $t)
        <p>{{ $t['author'] }}</p>
        <p>{{ $t['village'] }}</p>
    @endforeach
</div>