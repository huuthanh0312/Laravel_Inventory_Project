

class Notification {
    success() {
        Toast.fire({
            icon: 'success',
            title: 'Successfully Done'
            })
    }
    alert() {
        Toast.fire({
            icon: 'info',
            title: 'Are You Sure!'
            })
    }
    error() {
        Toast.fire({
            icon: 'error',
            title: 'Something Went Wrong !'
            })
    }
    warning() {
        Toast.fire({
            icon: 'warning',
            title: 'Oops Wrong'
            })
    }
    image_validation() {
        Toast.fire({
            icon: 'error',
            title: 'Upload Image Less Then 5MB'
            })
    }
    card_success() {
        Toast.fire({
            icon: 'success',
            title: 'Add To Cart Successfully'
            })
    }
    card_delete() {
        Toast.fire({
            icon: 'success',
            title: 'Deleted Product Successfully'
            })
    }
    card_error() {
        Toast.fire({
            icon: 'error',
            title: 'Add To Cart Invaild'
            })
    }



}

export default Notification = new Notification()







// class Notification {
//     success() {
//         new Noty({
//             type: 'success',
//             layout: 'topRight',
//             text: 'Successfully Done',
//             timeout: 1000,
//         }).show();
//     }
//     alert() {
//         new Noty({
//             type: 'alert',
//             layout: 'topRight',
//             text: 'Are You Sure',
//             timeout: 1000,
//         }).show();
//     }
//     error() {
//         new Noty({
//             type: 'error',
//             layout: 'topRight',
//             text: 'Something Went Wrong !',
//             timeout: 1000,
//         }).show();
//     }
//     warning() {
//         new Noty({
//             type: 'warning',
//             layout: 'topRight',
//             text: 'Oops Wrong',
//             timeout: 10000,
//         }).show();
//     }
//     image_validation() {
//         new Noty({
//             type: 'error',
//             layout: 'topRight',
//             text: 'Upload Image Less Then 10MB',
//             timeout: 10000,
//         }).show();
//     }



// }