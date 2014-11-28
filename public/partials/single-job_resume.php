<?php $object = get_queried_object();
      $post_type = get_post_type_object( $object->post_type ); 
      $meta = Wp_Linfo_Job_Public::get_vacancy_data($object->ID); ?>

<?php get_header();?>
<div id="primary" class="col-xs-9">
    <div class="row">
        <div id="content" class="col-xs-12" role="main">
            <div><?php Wp_Linfo_Job_Public::breadcrumbs( $post_type ) ?></div>
            <div class="content-header row"> <?php Wp_Linfo_Job_Public::title( $post_type ) ?> </div>
            <div class="job__aside_links">
                <?= Wp_Linfo_Job_Public::get_archive_link('vacancy') ?>
                <button type="button" class="vacancy__remove icon-cancel" title="Для удаления введите ключ"></button>
            </div>
            <div class="job__flash"><?= Wp_Linfo_Job_Public::flashmessages() ?></div>
            <h3 class="vacancy__title"><?= $object->post_title ?></h3>
            <input type="hidden" name="obj_id" id="obj_id" value="<?= $object->ID ?>">
            <div class="vacancy">
                <div class="vacancy__education">
                    <dt>Образование</dt>
                    <dd><?= Job_Meta_Boxes::get_elem('education', $meta['edu']) ?></dd>
                </div>
                <div class="vacancy__stage">
                    <dt>Опыт</dt>
                    <dd><?= Job_Meta_Boxes::get_elem('stage', $meta['stage']) ?></dd>
                </div>
                <div class="vacancy__salary">
                    <dt>Оплата</dt> <dd><?= $meta['salary'] ?></dd>
                </div>
                <?php if (!empty($meta['desc'])) : ?>
                <div class="vacancy__desc">
                    <dt>Дополнительно</dt> <dd><?= nl2br($meta['desc']) ?></dd>
                </div>
                <?php endif ?>
            </div>
            <h3 class="contact__header">Контактные данные</h3>
            <div class="job__contact">
	            <?php if (!empty($meta['contact']['name'])) : ?>
	                <div class="contact__name">
	                    <dt>Контактное лицо</dt> <dd><?= $meta['contact']['name'] ?></dd>
	                </div>
	            <?php endif ?>
	            <?php if (!empty($meta['contact']['phone'])) : ?>
	                <div class="company__phone">
	                    <dt>Телефон</dt> <dd><?= $meta['contact']['phone'] ?></dd>
	                </div>
	            <?php endif ?>
	            <?php if (!empty($meta['contact']['email'])) : ?>
	                <div class="company__email">
	                    <dt>E-mail</dt> <dd><?= $meta['contact']['email'] ?></dd>
	                </div>
	            <?php endif ?>
	        </div>
        <div class="yashare-auto-init job__share"  data-yashareL10n="ru" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki" data-yashareTheme="counter" data-yashareType="small"></div>
    </div>
    </div>
</div>
<?php get_sidebar('left'); ?>
<?php get_footer(); ?>