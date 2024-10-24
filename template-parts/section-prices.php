<?php
$admission = get_field('visit-admission');
if ($admission): ?>
    <div class="font-superclarendon text-base/regular sm:text-regular/regular">
        <?php foreach ($admission as $item): ?>
            <div class="columns-2 pb-sp1">
                <p><?php echo pll__($item['category'], 'tailpress'); ?></p>
                <p><?php echo $item['price']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
