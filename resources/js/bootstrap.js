window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}


// Clipboard script
import ClipboardJS from 'clipboard'
var clipboard = new ClipboardJS('#button-link');

clipboard.on('success', function(e) {
    e.clearSelection();
});

// Datetime picker script
require('gemini-datepicker');
$('#date').datepicker({
    type: 'date',
    placeholder: 'Please enter the date',
    align: 'center'
});
$('#date_absence').datepicker({
    type: 'date',
    placeholder: 'Please enter the date',
    align: 'center'
});
$('#date_start').datepicker({
    type: 'datetime',
    placeholder: 'Please enter the date',
    align: 'center',
    format: 'yyyy-MM-ddTHH:mm', // Satisfy browser formatting requirements
});
$('#date_end').datepicker({
    type: 'datetime',
    placeholder: 'Please enter the date',
    align: 'center',
    format: 'yyyy-MM-ddTHH:mm', // Satisfy browser formatting requirements
});
$('#due_date').datepicker({
    type: 'datetime',
    placeholder: 'Please enter the date',
    align: 'left', // Setting a center alignment breaks the edit page.
    format: 'yyyy-MM-ddTHH:mm', // Satisfy browser formatting requirements
    startDate: new Date()
});

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
