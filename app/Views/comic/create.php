<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
	<div class="row">
		<div class="col-8">
			<h2 class="my-3">Adding Data Form</h2>
			<form action="/Comics/save" method="post" enctype="multipart/form-data">
				<?= csrf_field(); ?>
				<div class="row mb-3">
					<label for="title" class="col-sm-2 col-form-label">Title</label>
					<div class="col-sm-10">
						<input type="text" class="form-control <?= ($validation->hasError('title')) ? 'is-invalid' : ''; ?>" id="title" name="title" autofocus value="<?=old('title'); ?>">
							<div class="invalid-feedback">
								<?= $validation->getError('title'); ?>
							</div>
					</div>
				</div>
				<div class="row mb-3">
					<label for="penulis" class="col-sm-2 col-form-label">Writer</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="penulis" name="penulis" value="<?=old('penulis'); ?>">
					</div>
				</div>
				<div class="row mb-3">
					<label for="penerbit" class="col-sm-2 col-form-label">Publisher</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="penerbit" name="penerbit" value="<?=old('penerbit'); ?>">
					</div>
				</div>
				<div class="row mb-3">
					<label for="sampul" class="col-sm-2 col-form-label" >Cover</label>
					<div class="col-sm-2">
						<img src="/img/default.png" class="img-thumbnail img-preview">
					</div>
					<div class="col-sm-8">
						<div class="input-group mb-3">
						  <input type="file" class="form-control <?= ($validation->hasError('sampul')) ? 'is-invalid' : ''; ?>" id="sampul" name="sampul" onChange="previewImg()">
							<div class="invalid-feedback">
									<?= $validation->getError('sampul'); ?>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Add data</button>
			</form>
		</div>		
	</div>
</div>


<?= $this->endSection(); ?>