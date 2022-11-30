<script src="<?= base_url('assets/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/adminlte.js'); ?>"></script>
<script src="<?= base_url('node_modules/sweetalert2/dist/sweetalert2.min.js'); ?>"></script>
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