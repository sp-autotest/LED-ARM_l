

<script src="/assets/js/bundle.js"></script>
<script src="/assets/js/theme/apple.js"></script>
<script src="/assets/js/apps.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="/assets/plugins/bootstrap-datetimepicker/datetimepicker.js"></script>
<!--<script src="/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>-->
<script>
		$(document).ready(function() {
			App.init();

			$(function() {
                $('input[name="period_from"]').datetimepicker({
                    format: 'DD.MM.YYYY',
                    locale: 'ru',
                });

                $('input[name="period_to"]').datetimepicker({
                    format: 'DD.MM.YYYY',
                    locale: 'ru',
                });


                $('#time_departure_at').datetimepicker({
                    format: 'HH:mm',
                    icons: {
                        up: "fa fa-chevron-up",
                        down: "fa fa-chevron-down"
                    }
                });
                $('#time_arrival_at').datetimepicker({
                    format: 'HH:mm',
                    icons: {
                        up: "fa fa-chevron-up",
                        down: "fa fa-chevron-down"
                    }
                });
            });
		});
</script>

@stack('scripts')