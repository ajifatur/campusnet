<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    let DateRangePicker = (selector, time = {}) => {
        return $(selector).daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            showDropdowns: true,
            startDate: time.start !== undefined ? time.start : moment().startOf('hour'),
            endDate: time.end !== undefined ? time.end : moment().startOf('hour').add(48, 'hour'),
            locale: {
                format: 'DD/MM/YYYY HH:mm'
            }
        });
    }
</script>