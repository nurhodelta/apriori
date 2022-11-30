</div>
<script src="<?= base_url('assets/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/select2/dist/js/select2.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/adminlte.min.js'); ?>"></script>
<script src="<?= base_url('node_modules/sweetalert2/dist/sweetalert2.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatable/js/jquery.datatable.js'); ?>"></script>
<script src="<?= base_url('assets/datatable/js/datatable.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.validate.min.js'); ?>"></script>

<?php 

    if ($scripts) {
        foreach ($scripts as $script) {
            ?>
            <script src="<?= $script; ?>"></script>
            <?php
        }    
       
    }

?>

</body>
</html>