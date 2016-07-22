<?php
    $this->load->view('templates/_header');
?>
<div class="page-container">
    <?php 
        $this->load->view('templates/_navigation_menu');
    ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">
                    Welcome, <?php $user = $this->session->userdata('login');
                        echo $user['customer_firstname']; ?>
                    </h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo base_url();?>home">
                                Dashboard
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    $this->load->view('templates/_footer');
?>