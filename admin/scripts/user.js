let user_picture_inp=document.getElementById('user_picture_inp');

document.getElementById('user_s_form').addEventListener('submit', function (e) {
    e.preventDefault();
    add_image();
});

function add_image() {
    let data = new FormData();
    data.append('picture', user_picture_inp.files[0]);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/user_crud.php", true);

    xhr.onload = function () {
        let myModal = document.getElementById('user-s');
        let modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        switch (this.responseText) {
            case 'inv_img':
                alert('error', 'Only JPG and PNG images are allowed');
                break;
            case 'inv_size':
                alert('error', 'Image should be less than 2MB!');
                break;
            case 'upd_failed':
                alert('error', 'Image upload failed due to server error!');
                break;
            default:
                alert('success', 'New image added!');
                user_picture_inp.value = '';
                get_user();
        }
    };

    xhr.send(data);
}
function get_user() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/user_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById("user-data").innerHTML = this.responseText;
        } else {
            alert("Failed to load members.");
        }
    }
    xhr.send("get_user=true");
}

function rem_user(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/user_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Image removed!');
            get_user(); 
        } else {
            alert('error', 'Failed to remove Image. Server error!');
        }
    };
    xhr.send("rem_user=" + val);
}
window.onload = function () {
    get_user();
};