<?php

return [
    'exception_message' => 'Thông báo ngoại lệ: :message',
    'exception_trace' => 'Dấu vết ngoại lệ: :trace',
    'exception_message_title' => 'Thông báo ngoại lệ',
    'exception_trace_title' => 'Dấu vết ngoại lệ',

    'backup_failed_subject' => 'Sao lưu thất bại của :application_name',
    'backup_failed_body' => 'Quan trọng: Đã xảy ra lỗi khi sao lưu :application_name',

    'backup_successful_subject' => 'Sao lưu mới thành công của :application_name',
    'backup_successful_subject_title' => 'Sao lưu mới thành công!',
    'backup_successful_body' => 'Tin tốt, bản sao lưu mới của :application_name đã được tạo thành công trên đĩa :disk_name.',

    'cleanup_failed_subject' => 'Dọn dẹp sao lưu của :application_name thất bại.',
    'cleanup_failed_body' => 'Đã xảy ra lỗi khi dọn dẹp các bản sao lưu của :application_name',

    'cleanup_successful_subject' => 'Dọn dẹp sao lưu của :application_name thành công',
    'cleanup_successful_subject_title' => 'Dọn dẹp sao lưu thành công!',
    'cleanup_successful_body' => 'Việc dọn dẹp các bản sao lưu của :application_name trên đĩa :disk_name đã thành công.',

    'healthy_backup_found_subject' => 'Các bản sao lưu của :application_name trên đĩa :disk_name đang ổn định',
    'healthy_backup_found_subject_title' => 'Các bản sao lưu của :application_name đang ổn định',
    'healthy_backup_found_body' => 'Các bản sao lưu của :application_name được đánh giá là ổn định. Làm tốt lắm!',

    'unhealthy_backup_found_subject' => 'Quan trọng: Các bản sao lưu của :application_name không ổn định',
    'unhealthy_backup_found_subject_title' => 'Quan trọng: Các bản sao lưu của :application_name không ổn định. :problem',
    'unhealthy_backup_found_body' => 'Các bản sao lưu của :application_name trên đĩa :disk_name không ổn định.',
    'unhealthy_backup_found_not_reachable' => 'Không thể truy cập được điểm đến sao lưu. :error',
    'unhealthy_backup_found_empty' => 'Không có bản sao lưu nào của ứng dụng này.',
    'unhealthy_backup_found_old' => 'Bản sao lưu mới nhất vào ngày :date được xem là quá cũ.',
    'unhealthy_backup_found_unknown' => 'Rất tiếc, không thể xác định chính xác nguyên nhân.',
    'unhealthy_backup_found_full' => 'Các bản sao lưu đang sử dụng quá nhiều dung lượng lưu trữ. Hiện đang dùng :disk_usage, vượt quá giới hạn cho phép là :disk_limit.',

    'no_backups_info' => 'Chưa có bản sao lưu nào được tạo',
    'application_name' => 'Tên ứng dụng',
    'backup_name' => 'Tên bản sao lưu',
    'disk' => 'Đĩa',
    'newest_backup_size' => 'Kích thước bản sao lưu mới nhất',
    'number_of_backups' => 'Số lượng bản sao lưu',
    'total_storage_used' => 'Tổng dung lượng đã sử dụng',
    'newest_backup_date' => 'Ngày sao lưu mới nhất',
    'oldest_backup_date' => 'Ngày sao lưu cũ nhất',
];
