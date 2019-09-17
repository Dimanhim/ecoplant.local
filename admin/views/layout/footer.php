        </div>
    </main>

    <footer class="page-footer grey darken-4">
        <div class="footer-copyright">
            <div class="container">
                &copy; 2005 - <?php echo date("Y"); ?>. EcoPlant Organisation.&nbsp;Все права защищены.
            </div>
        </div>
    </footer>

    <script>
        Date.prototype.daysInMonth = function() {
            return 33 - new Date(this.getFullYear(), this.getMonth(), 33).getDate();
        };
    </script>
    <script src="<?php echo PATH; ?>/template/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo PATH; ?>/template/js/materialize.min.js"></script>
    <script src="<?php echo PATH; ?>/template/js/Chart.min.js"></script>
    <script src="<?php echo PATH; ?>/template/js/Chart.main.js"></script>
    <script src="<?php echo PATH; ?>/template/js/autocomplete.select.plugin.js"></script>
    <script>
        var PATH = '<?php echo PATH; ?>';
    </script>
    <script src="<?php echo PATH; ?>/template/js/main.js?date=<?php echo filemtime(ROOT . '/template/js/main.js'); ?>"></script>
</body>
</html>