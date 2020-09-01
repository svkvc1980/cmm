<ul class="page-breadcrumb breadcrumb" style="padding: 20px 0;">
    <?php
        if(isset($breadCrumbOptions))
        {
            $bCount = count($breadCrumbOptions);
            if($bCount>0)
            {
                $i = 0;
                foreach($breadCrumbOptions as $bCrumb)
                {
                    $bClass = $bCrumb['class'];
                    $bLable = $bCrumb['label'];
                    $bUrl = $bCrumb['url'];
                    echo '<li class="'.$bClass.'">';
                    if($i > 0)
                        echo ' <i class="fa fa-circle"></i> ';
                    if($bUrl!='')
                    echo '<a href="'.$bUrl.'">'.$bLable.'</a> ';
                    else
                    echo '<span>'.$bLable.'</span>';
                    echo '</li>';
                    $i++;
                }
            }
        }
        ?>
</ul>