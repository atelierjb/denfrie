<?php if( have_rows('team') ): ?>
    <?php while( have_rows('team') ): the_row(); ?>
        <?php if( get_row_layout() == 'team-member' ): ?>
            <div class="pb-sp4 break-inside-avoid">
                <?php
                // Fetch ACF fields for each team member
                $team_member_title = get_sub_field('team-member-title');
                $team_member_name = get_sub_field('team-member-name');
                $team_member_mail = get_sub_field('team-member-mail');
                $team_member_phone = get_sub_field('team-member-phone');
                ?>
                
                <!-- Output the team member details -->
                <?php if( $team_member_title ): ?>
                    <p class="underline animateOnView"><?php echo esc_html($team_member_title); ?></p>
                <?php endif; ?>

                <?php if( $team_member_name ): ?>
                    <p class="animateOnView"><?php echo esc_html($team_member_name); ?></p>
                <?php endif; ?>

                <?php if( $team_member_mail ): ?>
                    <p class="hover:text-df-red w-fit animateOnView">
                        <a href="mailto:<?php echo esc_attr($team_member_mail); ?>"><?php echo esc_html($team_member_mail); ?></a>
                    </p>
                <?php endif; ?>

                <?php if( $team_member_phone ): ?>
                    <p class="hover:text-df-red w-fit animateOnView">
                        <a href="tel:<?php echo esc_attr($team_member_phone); ?>"><?php echo esc_html($team_member_phone); ?></a>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>



<p class="underline animateOnView"><?php echo esc_html( get_field('about-title-servicestaff') ); ?></p>
<?php if( have_rows('service-staff') ): ?>
    <?php while( have_rows('service-staff') ): the_row(); ?>
        <?php
        // Fetch the service staff name
        $service_staff_name = get_sub_field('service-staff-name');
        ?>
        
        <?php if( $service_staff_name ): ?>
            <p class="animateOnView"><?php echo esc_html($service_staff_name); ?></p>
        <?php endif; ?>
        
    <?php endwhile; ?>
<?php endif; ?>
