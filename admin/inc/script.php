<script>
    function alert(type, msg) {
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');

        element.innerHTML = `
        <div class="alert ${bs_class} alert-dismissible fade show custom-alert" role="alert" 
            style="position: fixed; top: 80px; right: 20px; z-index: 1050; width: auto;">
            <strong class="me-3">${msg}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        document.body.appendChild(element);

        
        setTimeout(() => {
            element.remove();
        }, 3000);
    }
    function handleResponse(responseText) {
        if (responseText == 1) {
            alert('success', 'Changes saved!');
            get_general(); 
        } else {
            alert('error', 'No changes made!');
        }
    }
</script>
