<?php
/** 
 * Archives
 *
 * @package custom
 *  
 * @author      熊猫小A
 * @version     2019-01-17 0.1
 * 
*/ 
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$setting = $GLOBALS['VOIDSetting'];
 
if(!Utils::isPjax()){
    $this->need('includes/head.php');
    $this->need('includes/header.php');
} 
?>

<main id="pjax-container">
    <title hidden>
        <?php Contents::title($this); ?>
    </title>
    
    <?php $this->need('includes/banner.php'); ?>

    <div class="wrapper container">
        <section id="archive-list" class="yue">
            <h1 <?php if($setting['titleinbanner']) echo 'hidden'; ?> class="post-title"><?php $this->title(); ?></h1>
            <?php if(!$setting['titleinbanner']): ?>
            <p class="post-meta">
                <?php 
                    echo Utils::getCatNum()." 分类 × ".Utils::getPostNum()." 文章 × ".Utils::getTagNum()." 标签 × <span id=\"totalWordCount\"></span> 字";
                ?>
            </p>
            <?php endif; ?>
            <div class="tag-cloud">
                <h1>Tags</h1>
                <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=count&ignoreZeroCount=1&desc=1&limit=50')->to($tags); ?>
                <?php if($tags->have()): ?>
                <?php while ($tags->next()): ?>
                    <a href="<?php $tags->permalink(); ?>" rel="tag" class="tag-item btn btn-normal btn-narrow" title="<?php $tags->count(); ?> 个话题"><?php $tags->name(); ?></a>
                <?php endwhile; ?>
                <?php else: ?>
                    <?php echo('还没有标签哦～'); ?>
                <?php endif; ?>
            </div>
            <?php $archives = Contents::archives($this); $index = 0; foreach ($archives as $year => $posts): ?>
                <section aria-label="<?php echo $year; ?>年归档列表"  class="year<?php if($index > 0) echo ' shrink'; ?>" data-year="<?php echo $year; ?>" data-num="<?php echo count($posts); ?>">
                    <ul>
                <?php foreach($posts as $created => $post): ?>
                        <li data-date="<?php echo date('m-d', $created); ?>"><a class="archive-title<?php if($setting['VOIDPlugin']) echo ' show-word-count'; ?>" data-words="<?php if($setting['VOIDPlugin']) echo $post['words']; ?>" href="<?php echo $post['permalink']; ?>"><?php echo $post['title']; ?></a></li>
                <?php endforeach; ?>
                    </ul>
                    <a role=button aria-label="收起与展开列表" class="toggle-archive" target="_self" href="javascript:void(0);" onclick="VOID.toggleArchive(this);"><?php if($index > 0) echo '+'; else echo '-'; ?></a>
                </section>
            <?php $index = $index + 1; endforeach; ?>
        </section>
        <!--评论区，可选-->
        <?php if ($this->allow('comment')) $this->need('includes/comments.php'); ?>
    </div>
</main>

<?php 
if(!Utils::isPjax()){
    $this->need('includes/footer.php');
} 
?>