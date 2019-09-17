    </div>
</main>
<footer class="page-footer green">
    <div class="footer-copyright">
        <div class="container">
            © 2005 - <?php echo date("Y"); ?>. EcoPlant Organisation. Все права защищены.
            <ul class="links">
                <li><a class="grey-text text-lighten-3" href="http://www.ecoplant.org/ru">EcoPlant</a></li>
                <li><a class="grey-text text-lighten-3" href="http://www.agro.ecoplant.org">EcoPlant Агро</a></li>
            </ul>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<script>
    var PATH = '<?php echo PATH; ?>';
</script>
<script src="<?php echo PATH; ?>/template/js/materialize.min.js"></script>
<script src="<?php echo PATH; ?>/template/js/main.js?date=<?php echo filemtime(ROOT . '/template/js/main.js'); ?>"></script>
<?php
if (isset($showModalAddImageObject) && $showModalAddImageObject) { ?>
    <script>
        $(document).ready(function() {
            $('#addImageObject').modal('open');
        });
    </script>
    <?php
} ?>
</body>
</html>
