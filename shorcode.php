<?php
add_shortcode('schedule_shorcode','playgarden_shorcode');
function playgarden_shorcode(){
    ob_start();// open for shorchode
    $args = array(
        'post_status' => 'publish',
        'post_type' => 'schedules'
    );
    $schedule = new WP_Query($args);
    ?>
    
        <div class="content-cards-schedule">
            <?php
            $countSchedule = 0;
            while($schedule->have_posts()): $schedule->the_post(); 
                $opciones = get_post_meta(get_the_ID()  );
                $date_schedule = DateTime::createFromFormat("Y-m-d",$opciones['pgo_date'][0]);
                $date_now = date("Y-m-d");
                if(strtotime($date_schedule->format('Y-m-d')) >= strtotime($date_now)){
                    $countSchedule ++;
            ?>
                <label for="schedule-<?php echo get_the_ID(); ?>" class="card-schedule">
                    <input type="radio" name="schedule-select" id="schedule-<?php echo get_the_ID(); ?>" value="D:<?php echo $opciones['pgo_date'][0] ?>;TI:<?php echo $opciones['pgo_time_init'][0] ?>;TF:<?php echo $opciones['pgo_time_finish'][0] ?>" <?php if($countSchedule==1) echo 'checked'?>>
                    <div class="option-selected">
                        <img src="<?php echo plugins_url('../../assets/check.svg',__FILE__) ?>" alt="">
                    </div>
                    <div class="info">
                        <strong>Date</strong>
                        <span><?php echo $date_schedule->format('F j, Y') ?></span>
                        <strong class="time">Time</strong>
                        <span><?php echo $opciones['pgo_time_init'][0] ?> - <?php echo $opciones['pgo_time_finish'][0] ?> <small>(GMT-5)</small></span>
                    </div>
                </label>
            <?php } //end if for select if time is correct
                endwhile; ?>
        </div>
    <?php
    $output = ob_get_clean(); // close for shorcode
    return $output; // return all echos
}