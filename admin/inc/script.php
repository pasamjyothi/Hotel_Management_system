<script>
function alert(type, msg, position='body') {
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');

        element.innerHTML = `
        <div class="alert ${bs_class} alert-dismissible fade show custom-alert" role="alert" 
            style="position: fixed; top: 80px; right: 20px; z-index: 1050; width: auto;">
            <strong class="me-3">${msg}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;

        if(position='body'){
        document.body.appendChild(element);
        element.classList.add('custom-alert');
        }
        else{
            document.getElementById(position).appendChild(element);
        }
        setTimeout(() => {
            element.remove();
        }, 3000);
        setTimeout(remAlert,2000);
    }
    function remAlert() {
    let alertBox = document.getElementById("alert-box");
    if (alertBox) {
        alertBox.remove();
    }
}

function handleResponse(responseText) {
        if (responseText == 1) {
            alert('success', 'Changes saved!');
            get_general(); 
        } else {
            alert('error', 'No changes made!');
        }
}
function setActive(){
   let  navbar=document.getElementById('nav-bar');
   let a_tags=navbar.getElementsByTagName('a');
   for(i=0;i<a_tags.length;i++){
    let file=a_tags[i].href.split('/').pop();
    let file_name=file.split('.')[0];
    if(document.location.href.indexOf(file_name)>=0){
      a_tags[i].classList.add('active');
    }

   }
}
</script>
