var username = $("#full_name").text();
var interval = 5 * 60 * 1000; //5 min

checkForMessages();
updateActivity();
checkActivity();

setInterval(function(){
    checkForMessages();
    updateActivity();
    checkActivity();
}, interval)

function updateActivity() {
    $.ajax({
        type: "GET",
        url : base_url+'/chat/updateActivity',
        timeout: 3000
    });
}

function checkActivity() {
    $.ajax({
        type: "GET",
        url : base_url+'/chat/checkActivity',
        timeout: 3000,
        success : function(data){
            $('.lista-useri .media').html(function(){
                var id = $(this).data('id');
                var status = (parseInt(data[id]) || 0) + 5 < Math.floor(Date.now() / 1000) ? 'OFFLINE' : '<span style="color: greenyellow;">ONLINE</span>';
                $(this).find('.media-heading-sub').html(status);
            });
        },
        error: function(data) {
            console.log(data.responseText);
        }
    });
}


function preparePost(dir, time, name, message) {
    var tpl = '';
    tpl += '<div class="post '+ dir +'" >';
    tpl += '<img class="avatar" alt="" src="'+base_url+'/images/avatar.png"/>';
    tpl += '<div class="message">';
    tpl += '<span class="arrow"></span>';
    tpl += '<a href="#" class="name">' + name + '</a>&nbsp;';
    tpl += '<span class="datetime" title="'+time+'">' + time.substr(time.indexOf(' ')+1) + '</span>';
    tpl += '<span class="body">';
    tpl += message;
    tpl += '</span>';
    tpl += '</div>';
    tpl += '</div>';

    return tpl;
}

function getLastPostPos(chatContainer) {
    var height = 0;
    chatContainer.find(".post").each(function() {
        height = height + $(this).outerHeight();
    });

    return height;
}

function checkForMessages()
{
    $.ajax({
        type: "POST",
        url : base_url+'/chat/checkForMessages',
        timeout: 3000,
        success: function(data) {
            
            var wrapper = $('.page-quick-sidebar-wrapper');
            var wrapperChat = wrapper.find('.page-quick-sidebar-chat');
            var chatContainer = wrapperChat.find(".page-quick-sidebar-chat-user-messages");
            if (data.length && data[0] != '<') {

                $('.media[data-id="'+(data[0].sender.id)+'"] .user-chat').show().find('.badge').text('new');

                if(data[0].showed == 0) {

                    sender = data[0].sender.full_name;
                    time = data[0].created_at;
                    message = data[0].message;

                    toastr.success(sender + ": " + message);
                    var message = preparePost('in', time, sender, message);
                    message = $(message);
                    chatContainer.append(message);
                }

                chatContainer.slimScroll({
                    scrollTo: getLastPostPos(chatContainer)
                });

                $('#chat-sidebar').addClass("red-color-notification");
            } else {
                $('.media .user-chat').hide();
            }
        },
        error: function(data) {
            console.log(data.responseText);
        }
    });
}

/**
Core script to handle the entire theme and core functions
**/
var QuickSidebar = function () {

    // Handles quick sidebar toggler
    var handleQuickSidebarToggler = function () {
        // quick sidebar toggler
        $('#chat-sidebar').click(function (e) {
            $('body').toggleClass('page-quick-sidebar-open');
            $('#chat-sidebar').removeClass("red-color-notification");
        });
    };

    // Handles quick sidebar chats
    var handleQuickSidebarChat = function () {
        var wrapper = $('.page-quick-sidebar-wrapper');
        var wrapperChat = wrapper.find('.page-quick-sidebar-chat');

        var initChatSlimScroll = function () {
            var chatUsers = wrapper.find('.page-quick-sidebar-chat-users');
            var chatUsersHeight;

            chatUsersHeight = wrapper.height() - wrapper.find('.nav-justified > .nav-tabs').outerHeight();

            // chat user list
            Metronic.destroySlimScroll(chatUsers);
            chatUsers.attr("data-height", chatUsersHeight);
            Metronic.initSlimScroll(chatUsers);

            var chatMessages = wrapperChat.find('.page-quick-sidebar-chat-user-messages');
            var chatMessagesHeight = chatUsersHeight - wrapperChat.find('.page-quick-sidebar-chat-user-form').outerHeight() - wrapperChat.find('.page-quick-sidebar-nav').outerHeight();

            // user chat messages
            Metronic.destroySlimScroll(chatMessages);
            chatMessages.attr("data-height", chatMessagesHeight);
            Metronic.initSlimScroll(chatMessages);
        };

        initChatSlimScroll();
        Metronic.addResizeHandler(initChatSlimScroll); // reinitialize on window resize


        wrapper.find('.page-quick-sidebar-chat-users').delegate(".media-list > .media", "click", function () {
            $('.page-quick-sidebar-chat-user-messages').hide();
            $('.load-messages').show();
            window.destinatar  = $(this).data('id');
            $.post(base_url+'/chat/getConversation', {id: destinatar}, function(data)
            {
                $('.load-messages').hide();
                $('.page-quick-sidebar-chat-user-messages').html(data);
                $('.page-quick-sidebar-chat-user-messages').show();
                $('.media-status').hide();
                var chatContainer = wrapperChat.find(".page-quick-sidebar-chat-user-messages");
                
                chatContainer.slimScroll({
                    scrollTo: getLastPostPos(chatContainer)
                });
            }).fail(function(data){
                console.log(data);
            });
            wrapperChat.addClass("page-quick-sidebar-content-item-shown");

        });

        wrapper.find('.page-quick-sidebar-chat-user .page-quick-sidebar-back-to-list').click(function () {
            wrapperChat.removeClass("page-quick-sidebar-content-item-shown");
        });

        var handleChatMessagePost = function (e) {
            e.preventDefault();

            var chatContainer = wrapperChat.find(".page-quick-sidebar-chat-user-messages");
            var input = wrapperChat.find('.page-quick-sidebar-chat-user-form .form-control');

            var text = input.val();
            if (text.length === 0) {
                return;
            }

            $.post(base_url+'/chat/sendMessage', {send_to: destinatar, message: text}, function(time){
                
                var message = preparePost('out', time, username, text);
                
                chatContainer.append(message);

                chatContainer.slimScroll({
                    scrollTo: getLastPostPos(chatContainer)
                });

                input.val("");
            });
            
        };

        wrapperChat.find('.page-quick-sidebar-chat-user-form .btn').click(handleChatMessagePost);
        wrapperChat.find('.page-quick-sidebar-chat-user-form .form-control').keypress(function (e) {
            if (e.which == 13) {
                handleChatMessagePost(e);
                return false;
            }
        });
    };

    // Handles quick sidebar tasks
    var handleQuickSidebarAlerts = function () {
        var wrapper = $('.page-quick-sidebar-wrapper');
        var wrapperAlerts = wrapper.find('.page-quick-sidebar-alerts');

        var initAlertsSlimScroll = function () {
            var alertList = wrapper.find('.page-quick-sidebar-alerts-list');
            var alertListHeight;

            alertListHeight = wrapper.height() - wrapper.find('.nav-justified > .nav-tabs').outerHeight();

            // alerts list
            Metronic.destroySlimScroll(alertList);
            alertList.attr("data-height", alertListHeight);
            Metronic.initSlimScroll(alertList);
        };

        initAlertsSlimScroll();
        Metronic.addResizeHandler(initAlertsSlimScroll); // reinitialize on window resize
    };

    // Handles quick sidebar settings
    var handleQuickSidebarSettings = function () {
        var wrapper = $('.page-quick-sidebar-wrapper');
        var wrapperAlerts = wrapper.find('.page-quick-sidebar-settings');

        var initSettingsSlimScroll = function () {
            var settingsList = wrapper.find('.page-quick-sidebar-settings-list');
            var settingsListHeight;

            settingsListHeight = wrapper.height() - wrapper.find('.nav-justified > .nav-tabs').outerHeight();

            // alerts list
            Metronic.destroySlimScroll(settingsList);
            settingsList.attr("data-height", settingsListHeight);
            Metronic.initSlimScroll(settingsList);
        };

        initSettingsSlimScroll();
        Metronic.addResizeHandler(initSettingsSlimScroll); // reinitialize on window resize
    };

    return {

        init: function () {
            //layout handlers
            handleQuickSidebarToggler(); // handles quick sidebar's toggler
            handleQuickSidebarChat(); // handles quick sidebar's chats
            handleQuickSidebarAlerts(); // handles quick sidebar's alerts
            handleQuickSidebarSettings(); // handles quick sidebar's setting
        }
    };

}();