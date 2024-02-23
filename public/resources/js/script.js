(function ($) {
    "use strict";

    $('form').submit(function (e) {
        $('form button[type="submit"]').attr('disabled', true);
    });

    if (document.getElementById('posts')) {
        // on refresh page scroll to top
        window.addEventListener('DOMContentLoaded', function () {
            window.scrollTo(0, 0);
        });

        let posts = []
        const ws = new WebSocket('ws://localhost:8080');

        ws.onerror = (event) => {
            alert('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
            // delay 5 second and reload page
            setTimeout(() => {
                window.location.reload();
            }, 5000);

        }

        ws.onmessage = (event) => {
            const data = JSON.parse(event.data);
            if (data.op == 12 && (data.t == "POSTS" || data.t == "NEW_POST")) {
                posts = data.d;

                showPost();
            }
        }

        ws.onopen = () => {
            ws.send(JSON.stringify({
                "op": 11,
                "t": "GET_POSTS",
                "d": null
            }));

            // on scroll to footer send request to get more posts from server only 1 time
            let isRequest = false;

            // when scroll to footer of page only
            window.onscroll = () => {
                // if ws are close connect again
                if (ws.readyState == 3) {
                    window.location.reload();
                }
                if ($(window).scrollTop() + $(window).height() > $('footer').offset().top) {
                    // console.log('scroll to footer');
                    if (!isRequest) {
                        // console.log('send request');
                        isRequest = true;
                        ws.send(JSON.stringify({
                            "op": 11,
                            "t": "GET_POSTS",
                            "d": null
                        }));
                    }

                    setTimeout(() => {
                        isRequest = false;
                    }, 2000);
                }
            }
        }

        function showPost() {
            if (posts.length == 0) return;
            for (let i = 0; i < posts.length; i++) {
                const data = posts[i];
                // console.log(i)
                let message = `<div class="card">
                        <div class="card-body">
                            <div class="post-title d-flex align-items-center">
                                <a href="/profile/${data.account.username}">
                                    <img class="logo" src="${data.account.avatar}">
                                </a>
                                <div class="name">
                                    <a href="/profile/${data.account.username}">
                                        ${data.account.displayname}
                                    </a>
                                </div>
                                <div class="extra">
                                    <a href="/post/${data.post.id}" target="_blank">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                </div>`
                message += `</div>
                            <div class="post-info">${data.post.message}</div>`;
                if (data.images.length > 0) {
                    const p1 = data.images.length > 1 ? 2 : 1;
                    const p2 = data.images.length > 3 ? 2 : 1;
                    const p3 = data.images.length > 4 ? 3 : p2;
                    message += `<div class="post-img">
                                <div class="row row-cols-1 row-cols-sm-${p1} gx-1 gy-1">`;
                    for (let j = 0; j < data.images.length && j < 2; j++) {
                        message += (`<div class="col">
                                    <img src="${data.images[j]}">
                                </div>`);
                    }
                    message += `</div>`;
                    if (data.images.length > 2) {
                        message += `<div class="row row-cols-1 row-cols-sm-${p2} row-cols-md-${p3} gx-1 gy-1 pt-1">`;
                        for (let j = 2; j < data.images.length; j++) {
                            message += `<div class="col">
                                    <img src="${data.images[j]}">
                                </div>`;
                        }
                        message += ` </div>`;
                    }
                }

                message += `<div class="post-comment"><a class="btn" href="/post/${data.post.id}" target="_blank">ความคิดเห็น จำนวน ${data.post.comment} ข้อความ</a></div>
                        </div>
                    </div>`;

                $('#posts').append(message);
            }
            posts = [];
            $('#posts').linkify({
                target: "_blank"
            });
        };
    }

    const commentEdit = document.getElementById('comment-edit');
    if (commentEdit) {
        commentEdit.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget

            const id = button.getAttribute('data-bs-id')
            const messageText = document.getElementById(`comment-${id}`).textContent

            const idInput = commentEdit.querySelector('input[name="comment_id"]')
            idInput.value = id

            const message = commentEdit.querySelector('textarea[name="message"]')
            message.value = messageText
        })
    }
    const commentDelete = document.getElementById('comment-delete');
    if (commentDelete) {
        commentDelete.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget

            const id = button.getAttribute('data-bs-id')

            const idInput = commentDelete.querySelector('input[name="comment_id"]')
            idInput.value = id
        })
    }
})(jQuery);