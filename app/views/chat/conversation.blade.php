@foreach($messages as $message)
    @if($message->sender == Auth::user()->id) 
        <div class="post out">
            <img class="avatar" alt="" src="{{ URL::to('/images/avatar.png') }}">
            <div class="message">
                <span class="arrow"></span>
                <span class="name">{{ Auth::user()->full_name }}</span>
                <span class="datetime" title="{{ $message->created_at }}">{{ strstr($message->created_at, ' ') }}</span>
                <span class="body">{{ htmlentities($message->message) }}</span>
            </div>
        </div>
    @else
        <div class="post in">
            <img class="avatar" alt="" src="{{ URL::to('/images/avatar.png') }}">
            <div class="message">
                <span class="arrow"></span>
                <span class="name">{{ $message->sender()->first()->full_name }}</span>
                <span class="datetime" title="{{ $message->created_at }}">{{ strstr($message->created_at, ' ') }}</span>
                <span class="body">{{ htmlentities($message->message) }}</span>
            </div>
        </div>
    @endif
@endforeach