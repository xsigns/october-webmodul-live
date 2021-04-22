<?php
namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSlider extends Migration
{
    public function up()
    {
        DB::unprepared("INSERT INTO `xsigns_fewo_slide_shows` (`id`, `slide_show_title`, `slide_show_content`, `autoplay`, `accessibility`, `adaptive_height`, `autoplay_speed`, `arrows`, `prev_arrow`, `next_arrow`, `center_mode`, `center_padding`, `css_ease`, `dots`, `dots_class`, `draggable`, `fade`, `focus_on_select`, `easing`, `edge_friction`, `infinite`, `initial_slide`, `lazy_load`, `pause_on_focus`, `pause_on_hover`, `pause_on_dots_hover`, `responsive`, `rows`, `slides_per_row`, `slides_to_show`, `slides_to_scroll`, `speed`, `swipe`, `touch_move`, `touch_threshold`, `use_css`, `use_transform`, `vertical`, `vertical_swiping`, `rtl`, `wait_for_animate`, `z_index`, `slide_show_height`, `include_jquery`, `show_title`, `show_desc`, `include_thumb`, `thumb_height`, `thumb_images`, `thumb_top`, `show_asimages`, `asimages_height`) VALUES
(1, 'Objektdetails', '', 1, 1, 1, 6000, 1, '<button type=\"button\" class=\"slick-prev\">Previous</button>', '<button type=\"button\" class=\"slick-next\">Next</button>', 0, '50px', 'ease', 0, NULL, 1, 0, 0, 'linear', 0.15, 1, 0, 'ondemand', 1, 1, 0, '[]', 1, 1, 3, 1, 300, 1, 1, 5, 1, 1, 0, 0, 0, 0, 1000, '300px', 0, 0, 0, 1, '80px', 3, 20, 1, '500px');
");
    }
    public function down()
    {

    }
}