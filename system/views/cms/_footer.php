				<footer id="page-footer">
					<p class="copyright">Safanòria CMS © 2012 | <?php echo $this->version(); ?></p>
				</footer>
			</div><!-- /Page -->
		</div><!-- /Wrapper -->
		<script src="/public/resources/admin/js/jquery-1.7.1.min.js" type="text/javascript"></script>
		<script src="/public/resources/admin/js/select.js" type="text/javascript"></script>
		<script src="/public/resources/admin/js/anchor.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function(){
	           //create a new field then append it before the add field button
	           $("#add_images").click(function(){
	                 var new_field = "<div><input type=\"file\" name=\"related_img[]\" value=\"\" /></div>";
	                 $(this).before(new_field);
	           });
		     });
		</script>
	</body>
</html>