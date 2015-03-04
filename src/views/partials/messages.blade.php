@if (isset($messages))
  @foreach ($messages as $message)
    <p class="text-danger">{{ $message[0] }}</p>
  @endforeach
@endif