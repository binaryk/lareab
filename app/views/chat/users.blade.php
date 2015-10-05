@if(Auth::check())
    @if(isset($groups_with_users))
        @foreach ($groups_with_users as $group)
            @if (count($group->users))
                <h3 class="list-heading">{{ $group->name }}</h3>
                <ul class="media-list list-items">
                    @foreach ($group->users as $user)
                        <li class="media" data-id="{{ $user->id }}">
                            <?php if(ChatMessage::where("sender", '=', $user->id)->where('send_to', '=', Auth::user()->id)->where('read', 0)->count()) : ?>
                                <div class="media-status user-chat" >
                                    <span class="badge badge-success">new</span>
                            <?php else : ?>
                                <div class="media-status user-chat" style="display: none;">
                                    <span class="badge badge-success"></span>
                            <?php endif; ?>
                            </div>
                            <img class="media-object" src="{{ URL::to('images/avatar.png') }}" alt="...">
                            <div class="media-body">
                                <h4 class="media-heading">{{ $user->full_name }}</h4>
                                <div class="media-heading-sub">
                                    @if ($user->last_activity + 5 < time())
                                        OFFLINE
                                    @else
                                        <span style="color: greenyellow;">ONLINE</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    @endif
@endif
