<?php
include '../config.php';
    if($_GET['resource_id']) {

        $resource_id = $_GET['resource_id'];
        $user_id = $_SESSION['user_id'];


        $sql_report = "Delete from report where resource_id = ?";
        $stmt= $connection->prepare($sql_report);
        $stmt->execute([$resource_id]);
        if($stmt){
            if($_SESSION['is_admin']==1){
                $sql = "DELETE FROM resource WHERE resource_id=?";
                $stmt1= $connection->prepare($sql);
                $stmt1->execute([$resource_id]);
            }else{
                $sql = "DELETE FROM resource WHERE resource_id=? AND uploaded_by=?";
                $stmt1= $connection->prepare($sql);
                $stmt1->execute([$resource_id, $user_id]);
            }

            if($stmt1) {
                $_SESSION['success_msg'] = "Delete resources successfully.";
                $_SESSION['title_msg'] = "Resources";
                if($_GET['redirect'] == 'admin'){
                    $_SESSION['success_msg']= "Delete resources successfully.";
                    $_SESSION['title_msg'] = "Resources";
                    header("Location: ../admin_resources_view.php");
                } else {
                    $_SESSION['success_msg']= "Delete resources successfully.";
                    $_SESSION['title_msg'] = "Resources";
                    header("Location:../index.php");
                }

            } else {
                if($_GET['redirect'] == 'admin'){
                    $_SESSION['error_msg'] = "Failed to delete";
                    $_SESSION['title_msg'] = "Resources";
                    header("Location: ../admin_resources_view.php");
                } else {
                    $_SESSION['error_msg'] = "Failed to delete";
                    $_SESSION['title_msg'] = "Resources";
                    header("Location:../card.php?resource_id=$resource_id");
                }

            }
        }
        }
    else {
        if($_GET['redirect'] == 'admin'){
            $_SESSION['error_msg'] = "Failed to delete";
            $_SESSION['title_msg'] = "Resources";
            header("Location: ../admin_resources_view.php");
        } else {
            $_SESSION['error_msg'] = "Failed to delete";
            $_SESSION['title_msg'] = "Resources";
            header("Location:../card.php?resource_id=$resource_id");
        }
    }

    ?>