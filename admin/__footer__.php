</div>
</div>
</div>


</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    // $().daterangepicker();

    $(document).ready(function() {
        $('input[name="daterange"]').daterangepicker();
    });

    const AJAX_URL = "../backend/requestHandler.php";

    function logout() {
        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                action: 'logout',
            },
            success: function(result) {
                location.href = '../';
            }
        });
    }
</script>

</html>