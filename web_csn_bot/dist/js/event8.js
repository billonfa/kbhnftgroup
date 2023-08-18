
const div_message = document.querySelector('#message')
const formatDate = (date) => date.toLocaleTimeString("en-US", { hour: "2-digit", minute: "2-digit" });
const div_msger = document.querySelector('.msger')
window.addEventListener("load", () => {
    const req = new XMLHttpRequest();
    req.addEventListener("load", () => {
        JSON.parse(req.responseText).reverse().forEach(({ name, content, created_at, avatar_url, photo, forward_from, gif, sticker }) => {
            created_at = mon_day_hou_min(created_at)
            div_message.append(createDiv(name, content, created_at, avatar_url, photo, forward_from, gif, sticker));
            window.scrollTo(0, document.body.scrollHeight);
        });
    });
    add_function_img()
    req.open("GET", "get_data.php", true);
    req.send();
});

// Pusher.logToConsole = true;
var pusher = new Pusher('53d916e1cb5d74805c3a', {
    cluster: 'mt1'
});
const channel = pusher.subscribe("my-channel");
channel.bind("chat_casino", ({ name, message, hour_minutes, avatar_url, message_img, forward_from, url_gif, sticker }) => {
    hour_minutes = mon_day_hou_min(hour_minutes)
    div_message.append(createDiv(name, message, hour_minutes, avatar_url, message_img, forward_from, url_gif, sticker));
    window.scrollTo(0, document.body.scrollHeight);
});

const createDiv = (name, content, created_at, avatar, message_img, forward_from, gif, sticker) => {
    try {
        var name = JSON.parse(name)
    } catch (error) {

    }
    try {
        var content = JSON.parse(content)
    } catch (error) {

    }
    try {
        content = content.replace(/\n/g, "<br>")
    } catch (error) {
        // console.log("Đã xảy ra lỗi: " + error.message);
    }
    const div_left = document.createElement('div')
    div_left.classList.add('msg', 'left-msg', 'invisible')
    const div_img = document.createElement('div')
    div_img.classList.add('msg-img')
    const img_avt = document.createElement('img')
    img_avt.src = 'dist/media/img/avt_default.jpg'
    if (avatar != null) {
        img_avt.src = avatar
    }
    img_avt.style.width = '100%'
    img_avt.style.borderRadius = '35px'
    div_img.appendChild(img_avt)

    const msg_bubble = document.createElement('div')
    msg_bubble.classList.add('msg-bubble')
    const msg_info = document.createElement('div')
    msg_info.classList.add('msg-info')
    const msg_info_name = document.createElement('div')
    msg_info_name.classList.add('msg-info-name')
    msg_info_name.textContent = name
    const msg_info_time = document.createElement('i')
    msg_info_time.classList.add('msg-info-time')
    msg_info_time.textContent = created_at

    const msg_text = document.createElement('div')
    msg_text.classList.add('msg-text')
    msg_text.textContent = content

    if (message_img != null) {
        const div_text = document.createElement('div')
        div_text.textContent = content
        msg_text.textContent = ''
        const mess_photo = document.createElement('img')
        mess_photo.src = message_img
        mess_photo.classList.add('popup-image', 'message_photo')
        msg_text.append(mess_photo, div_text)
        setTimeout(() => {
            add_function_img()
        }, 0);
    }

    if (gif != null) {
        const video = document.createElement('video')
        video.style.width = '250px'
        video.controls = true
        // video.autoplay = true
        const source = document.createElement('source')
        source.src = gif;
        source.type = "video/mp4";
        video.appendChild(source)
        msg_text.appendChild(video)
    }

    if (sticker != null) {
        const img_sticker = document.createElement('img')
        img_sticker.classList.add('sticker')
        img_sticker.src = sticker
        img_sticker.classList.add('popup-image')
        msg_text.appendChild(img_sticker)
    }

    msg_info.append(msg_info_name, msg_info_time)
    msg_bubble.append(msg_info, msg_text)

    div_left.append(div_img, msg_bubble)
    return div_left
};

const mon_day_hou_min = (date) => {
    const timeString = date;
    const dateObj = new Date(timeString);
    let month = dateObj.getMonth() + 1;
    if (month < 10) {
        month = '0' + month
    }
    let day = dateObj.getDate();
    if (day < 10) {
        day = '0' + day
    }
    let hours = dateObj.getHours();
    if (hours < 10) {
        hours = '0' + hours
    }
    let minutes = dateObj.getMinutes();
    if (minutes < 10) {
        minutes = '0' + minutes
    }
    let formattedTime = `${month}-${day} ${hours}:${minutes}`;
    return formattedTime
}

const add_function_img = () => {
    var images = document.querySelectorAll(".popup-image");
    var modal = document.querySelector(".modal");

    for (var i = 0; i < images.length; i++) {
        images[i].addEventListener("click", function () {
            modal.classList.add("active");
            modal.children[0].children[1].src = this.src;
            modal.children[0].children[1].addEventListener("click", function () {
                modal.classList.remove("active");
            });
        });
    }

    modal.addEventListener("click", function (event) {
        if (event.target === this || event.target.classList.contains("modal-close")) {
            this.classList.remove("active");
        }
    });

    // Thêm sự kiện click cho hình ảnh
    modal.children[0].children[1].addEventListener("click", function (event) {
        // Ngăn chặn sự kiện click lan sang modal
        event.stopPropagation();
    });
}

// Member Online
var member = this.document.querySelector('#member_online')
this.setInterval(function () {
    var min = 15;
    var max = 120;
    var randomNum = Math.floor(Math.random() * (max - min + 1)) + min;
    member.innerHTML = randomNum
}, 15000)
