<?php
                $admission = get_field('visit-admission');
                if( $admission ): ?>
                    <div class="font-superclarendon text-base/regular sm:text-regular/regular">
                        <div class="columns-2 pb-sp1">
                            <p><?php echo pll__('+16 years', 'tailpress'); ?></p>
                            <p><?php echo $admission['admission-adults']; ?></p>
                        </div>
                        <div class="columns-2 pb-sp1">
                            <p><?php echo pll__('Seniors', 'tailpress'); ?></p>
                            <p><?php echo $admission['admission-seniors']; ?></p>
                        </div>
                        <div class="columns-2 pb-sp1">
                            <p><?php echo pll__('Students', 'tailpress'); ?></p>
                            <p><?php echo $admission['admission-students']; ?></p>
                        </div>
                        <div class="columns-2 pb-sp1">
                            <p><?php echo pll__('0—15 years', 'tailpress'); ?></p>
                            <p><?php echo $admission['admission-kids']; ?></p>
                        </div>
                        <div class="columns-2">
                            <p><?php echo pll__('w. Annual pass', 'tailpress'); ?></p>
                            <p><?php echo $admission['admission-annualpass']; ?></p>
                        </div>
                    </div>
                <?php endif; ?>