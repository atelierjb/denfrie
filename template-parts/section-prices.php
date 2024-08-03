<?php
                $admission = get_field('visit-admission');
                if( $admission ): ?>
                    <div class="font-superclarendon text-regular/regular">
                        <div class="columns-2 pb-[calc(0.2rem+0.5vw)]">
                            <p>+16 years</p>
                            <p><?php echo $admission['admission-adults']; ?></p>
                        </div>
                        <div class="columns-2 pb-[calc(0.2rem+0.5vw)]">
                            <p>Seniors</p>
                            <p><?php echo $admission['admission-seniors']; ?></p>
                        </div>
                        <div class="columns-2 pb-[calc(0.2rem+0.5vw)]">
                            <p>Students</p>
                            <p><?php echo $admission['admission-students']; ?></p>
                        </div>
                        <div class="columns-2 pb-[calc(0.2rem+0.5vw)]">
                            <p>0-15 years</p>
                            <p><?php echo $admission['admission-kids']; ?></p>
                        </div>
                        <div class="columns-2">
                            <p>w. Annual pass</p>
                            <p><?php echo $admission['admission-annualpass']; ?></p>
                        </div>
                    </div>
                <?php endif; ?>