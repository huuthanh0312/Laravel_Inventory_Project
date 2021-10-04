class Notification {
    success() {
        new Noty({
            type: 'success',
            layout: 'TopRight',
            text: 'Successfully Done',
            timeout: 1000,
        }).show();
    }
    alert() {
        new Noty({
            type: 'alert',
            layout: 'TopRight',
            text: 'Are You Sure',
            timeout: 1000,
        }).show();
    }
    error() {
        new Noty({
            type: 'error',
            layout: 'TopRight',
            text: 'Something Went Wrong !',
            timeout: 1000,
        }).show();
    }
    warning() {
        new Noty({
            type: 'warning',
            layout: 'TopRight',
            text: 'Oops Wrong',
            timeout: 1000,
        }).show();
    }



}

export default Notification = new Notification()