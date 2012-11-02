	<div class="row-fluid">
		<div class="span10">
			<form action="<?php echo $this->cms->url['add-post']; ?>" method="post" name="post_edit" enctype="multipart/form-data">
			
			<?php foreach($langs as $lang): ?>
				<fieldset class="lang-fieldset">
					<legend><?php echo $lang->name; ?></legend>
					
					<label for="title_<?php echo $lang->code; ?>"><?php echo $this->cms->message('title'); ?></label>
						<div class="form_error"><?php echo $this->cms->error_for('title'); ?></div>
						<input type="text" name="title_<?php echo $lang->code; ?>" id="title_<?php echo $lang->code; ?>" value="<?php echo $this->cms->input_for('title_'.$lang->code.''); ?>"/>
						
						<?php if($this->current['edit'] === FALSE): ?>
							<?php echo $this->cms->error_for('nice_url'); ?>
						<?php endif; ?>
						
					<label for="content_<?php echo $lang->code; ?>"><?php echo $this->cms->message('content'); ?></label>
						<div class="form_error"><?php echo $this->cms->error_for('content'); ?></div>
						<textarea name="content_<?php echo $lang->code; ?>" id="content_<?php echo $lang->code; ?>">
							<?php echo $this->cms->input_for('content_'.$lang->code.''); ?>
						</textarea>
						
					<label for="description_<?php echo $lang->code; ?>"><?php echo $this->cms->message('excerpt'); ?></label>
						<div class="form_error"><?php echo $this->cms->error_for('description'); ?></div>
						<input type="text" name="description_<?php echo $lang->code; ?>" id="description_<?php echo $lang->code; ?>" value="<?php echo $this->cms->input_for('description_'.$lang->code.''); ?>" />
				</fieldset>
			<?php endforeach; ?>
				
				<fieldset class="general-fieldset">	
					<legend>SEO</legend>	
					<label for="tags"><?php echo $this->cms->message('tags'); ?> <b><?php echo $this->cms->message('comma_separated'); ?></b></label>
						<div class="form_error"><?php echo $this->cms->error_for('tags'); ?></div>
						<input type="text" name="tags" id="tags" maxlength="150" value="" />
					
					<?php if($this->current['edit'] === TRUE): ?>
					<label for="nice_url"><?php echo $this->cms->message('nice_url'); ?></label>
						<div class="form_error"><?php echo $this->cms->error_for('nice_url'); ?></div>
						<input type="text" name="nice_url" id="nice_url" value="" />
					<?php endif; ?>
				</fieldset>
				
				<fieldset class="general-fieldset" id="img_fieldset">
					<legend>Imatges del projecte:</legend>
						<div><input type="file" name="related_img[]" id="related_img" value="" /></div>
				</fieldset>
				
				
				
				
				
				<!-- Button to trigger modal -->
				<a href="#modal_add_img" role="button" class="btn" data-toggle="modal">Launch demo modal</a>
				 
				<!-- Modal -->
				<div class="modal" id="modal_add_img" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">Drag & Drop your images here</h3>
					</div>
					<div class="modal-body">
						<p>Arrossega les teues iamtges ací</p>
						<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
							<!-- Redirect browsers with JavaScript disabled to the origin page -->
							<noscript><input type="hidden" name="redirect" value="http://blueimp.github.com/jQuery-File-Upload/"></noscript>
							<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
							<div class="row fileupload-buttonbar">
							<div class="span7">
							<!-- The fileinput-button span is used to style the file input field as button -->
							<span class="btn btn-success fileinput-button">
							<i class="icon-plus icon-white"></i>
							<span>Add files...</span>
							<input type="file" name="files[]" multiple>
							</span>
							<button type="submit" class="btn btn-primary start">
							<i class="icon-upload icon-white"></i>
							<span>Start upload</span>
							</button>
							<button type="reset" class="btn btn-warning cancel">
							<i class="icon-ban-circle icon-white"></i>
							<span>Cancel upload</span>
							</button>
							<button type="button" class="btn btn-danger delete">
							<i class="icon-trash icon-white"></i>
							<span>Delete</span>
							</button>
							<input type="checkbox" class="toggle">
							</div>
							<!-- The global progress information -->
							<div class="span5 fileupload-progress fade">
							<!-- The global progress bar -->
							<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="bar" style="width:0%;"></div>
							</div>
							<!-- The extended global progress information -->
							<div class="progress-extended">&nbsp;</div>
							</div>
							</div>
							<!-- The loading indicator is shown during file processing -->
							<div class="fileupload-loading"></div>
							<br>
							<!-- The table listing the files available for upload/download -->
							<table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
						</form>
						<!-- modal-gallery is the modal dialog used for the image gallery -->
						<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd" tabindex="-1">
						    <div class="modal-header">
						        <a class="close" data-dismiss="modal">&times;</a>
						        <h3 class="modal-title"></h3>
						    </div>
						    <div class="modal-body"><div class="modal-image"></div></div>
						    <div class="modal-footer">
						        <a class="btn modal-download" target="_blank">
						            <i class="icon-download"></i>
						            <span>Download</span>
						        </a>
						        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
						            <i class="icon-play icon-white"></i>
						            <span>Slideshow</span>
						        </a>
						        <a class="btn btn-info modal-prev">
						            <i class="icon-arrow-left icon-white"></i>
						            <span>Previous</span>
						        </a>
						        <a class="btn btn-primary modal-next">
						            <span>Next</span>
						            <i class="icon-arrow-right icon-white"></i>
						        </a>
						    </div>
						</div>
						<!-- The template to display files available for upload -->
						<script id="template-upload" type="text/x-tmpl">
						{% for (var i=0, file; file=o.files[i]; i++) { %}
						    <tr class="template-upload fade">
						        <td class="preview"><span class="fade"></span></td>
						        <td class="name"><span>{%=file.name%}</span></td>
						        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
						        {% if (file.error) { %}
						            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
						        {% } else if (o.files.valid && !i) { %}
						            <td>
						                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
						            </td>
						            <td class="start">{% if (!o.options.autoUpload) { %}
						                <button class="btn btn-primary">
						                    <i class="icon-upload icon-white"></i>
						                    <span>Start</span>
						                </button>
						            {% } %}</td>
						        {% } else { %}
						            <td colspan="2"></td>
						        {% } %}
						        <td class="cancel">{% if (!i) { %}
						            <button class="btn btn-warning">
						                <i class="icon-ban-circle icon-white"></i>
						                <span>Cancel</span>
						            </button>
						        {% } %}</td>
						    </tr>
						{% } %}
						</script>
						<!-- The template to display files available for download -->
						<script id="template-download" type="text/x-tmpl">
						{% for (var i=0, file; file=o.files[i]; i++) { %}
						    <tr class="template-download fade">
						        {% if (file.error) { %}
						            <td></td>
						            <td class="name"><span>{%=file.name%}</span></td>
						            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
						            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
						        {% } else { %}
						            <td class="preview">{% if (file.thumbnail_url) { %}
						                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
						            {% } %}</td>
						            <td class="name">
						                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
						            </td>
						            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
						            <td colspan="2"></td>
						        {% } %}
						        <td class="delete">
						            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
						                <i class="icon-trash icon-white"></i>
						                <span>Delete</span>
						            </button>
						            <input type="checkbox" name="delete" value="1">
						        </td>
						    </tr>
						{% } %}
						</script>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						<button class="btn btn-primary">Save changes</button>
					</div>
				</div>
				
				
				
				
				
				
				
				
		</div>
		<div class="span2">
			<fieldset class="general-fieldset">
				<legend><?php echo $this->cms->message('field_admin'); ?></legend>
				<label for="section"><?php echo $this->cms->message('post_section'); ?></label>
				<select name="section" id="section"> 
					<?php foreach($sections as $section): ?>
						<option value="<?php echo $section->identifier; ?>"><?php echo $section->title; ?></option>
						<?php $sublists = Section::all(array('parent'=>$section->identifier,'lang'=>$this->cms->administrator->clean['lang'])); ?>
						<?php foreach ($sublists as $sublist): ?>
							<option value="<?php echo $sublist->identifier; ?>">– <?php echo $sublist->title; ?></option>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</select>
				
				<?php if($this->have($cats)): ?>
				<label for="categories"><?php echo $this->cms->message('categories'); ?></label>
					<?php foreach($cats as $cat): ?>
						<input type="checkbox" name="categories[]" value="<?php echo $cat->identifier; ?>" /> <?php echo $cat->title; ?>
					<?php endforeach; ?>
				<?php endif; ?>
						
				<label for="author"><?php echo $this->cms->message('author'); ?></label>
					<div class="form_error"><?php echo $this->cms->error_for('author'); ?></div>
					<input type="text" name="author" id="author" value="<?php echo $this->cms->input_for('author', $this->cms->administrator->html['username']); ?>" />
				
				<label for="status"><?php echo $this->cms->message('status'); ?></label>
				<select name="status" id="status">
					<?php foreach($this->cms->post_status as $status): ?>
						<option value="<?php echo $status; ?>"><?php echo $this->message($status); ?></option>
					<?php endforeach; ?>
				</select>	
			</fieldset>
		</div>
	</div>
	<input type="hidden" name="token" value="<?php echo $this->current['token']; ?>" />
	<input type="submit" id="submit" class="btn" name="submit" value="<?php echo $this->cms->message('submit_post'); ?>" />
</form>
