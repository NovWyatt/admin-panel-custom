// resources/js/app.js
import './bootstrap';

// Import toastr
import toastr from 'toastr';

// Thiết lập toastr
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: 5000
};

// Đặt biến toàn cục để sử dụng trong các tệp khác
window.toastr = toastr;