// Jquery đồng bộ hóa 2 input là tags name và ids Đây là mảng json ánh xạ: ánh xạ giữa tags và ids
$(document).ready(function() {
    console.log(window.tagToIdMap);
    $('input[data-role="tagsinput"]').each(function() {
        // Xử lý đồng bộ hóa giữa các input text và hidden
        // console.log(tagToIdMap);
        var $tagInput = $(this);  // Thẻ input chứa tags
        var inputName = $tagInput.attr('name');  // Lấy tên của input (ví dụ: color, slogan, material)
        var $hiddenInput = $('#' + inputName + '_ids');  // Thẻ input hidden chứa id tương ứng
        var $addInput    = $('#' + inputName + '_add');
        var tagToIdMap   = window.tagToIdMap;
        // console.log($tagInput, $hiddenInput);  // Debug để đảm bảo đã lấy đúng các input

        // Xử lý khi tag bị xóa
        $tagInput.on('itemRemoved', function(event) {
            var removedTag = event.item.trim();  // Tên của tag vừa bị xóa
            console.log('Removed tag:', removedTag);  // Kiểm tra tag vừa bị xóa

            //Chuyển đổi ký tự in hoa về chữ thường
            removedTag = removedTag.toLowerCase();
            //Loại bỏ dấu tiếng việt
            removedTag = removeAccents(removedTag);
            // Chuyển khoảng trăng thành dấu `-`, điều này là bắt buộc nếu không phép so sánh chuỗi sẽ bị lỗi khi có khoảng trắng
            removedTag = removedTag.replace(/\s+/g, '-');
            // Loại bỏ dấu `-` ở đầu dòng và cuối dòng
            removedTag = removedTag.replace(/^-+|-+$/g, '');

            console.log(removedTag);

            // Lấy giá trị id của tag vừa bị xóa thông qua ánh xạ
            var removedTagId = tagToIdMap[removedTag];
            console.log('ID of removed tag:', removedTagId);  // Debug để kiểm tra ID


            if(removedTagId !== undefined){ // Trường hợp removedTagId có trong danh sách tagToIdMap, thì xóa tại hiddenId
                // Lấy tất cả các ids hiện tại
                var currentIds = $hiddenInput.val().split(',').map(id => id.trim());

                // Tìm và xóa id tương ứng
                var tagIdIndex = currentIds.indexOf(removedTagId.toString());  // Tìm vị trí của id tương ứng
                if (tagIdIndex > -1) {
                    currentIds.splice(tagIdIndex, 1);  // Xóa id
                }

                // Cập nhật lại giá trị của input hidden
                $hiddenInput.val(currentIds.join(','));
                console.log('Updated IDs:', $hiddenInput.val());  // Kiểm tra xem ID đã được cập nhật chưa
            }
            else{
                // Trường hợp removedTagId ko có trong danh sách tagToIdMap: vậy đây là tag mới tạo này nằm trong input add.
                // xóa phần tử ra khỏi input add (ví dụ:input name=color_add)

                //Lấy lại biến của sự kiện xóa
                var removedTagStr = event.item.trim();  // Tên của tag vừa bị xóa
                // Lấy tất cả các value của addInput
                var currentArrayAddInput = $addInput.val().split('|').map(id => id.trim());

                var tagIdIndex = currentArrayAddInput.indexOf(removedTagStr.toString());  // Tìm vị trí của id tương ứng
                if (tagIdIndex > -1) {
                    currentArrayAddInput.splice(tagIdIndex, 1);  // Xóa id
                }
                console.log(currentArrayAddInput);
                // Cập nhật lại giá trị mới vào input add
                $addInput.val(currentArrayAddInput.join('|'));
                console.log('Updated IDs:', $addInput.val());  // Kiểm tra xem ID đã được cập nhật chưa

            }

        });

        // Lắng nghe sự kiện khi phần tử mới được thêm
        $tagInput.on('itemAdded', function(event) {
            var newTag = event.item.trim(); // Tên của tag mới được thêm
            console.log('New tag:', newTag);  // Kiểm tra tag vừa bị xóa
            // Nếu addInput đã có giá trị, nối thêm vào với dấu
            if ($addInput.val()) {
                $addInput.val($addInput.val() + '|' + newTag);
            } else {
                // Nếu chưa có giá trị thì chỉ gán giá trị mới
                $addInput.val(newTag);
            }
        });

    });


    //Phương thức loại bỏ dấu tiếng Việt
    function removeAccents(str) {
        var accents = [
            'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
            'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
            'ì', 'í', 'ị', 'ỉ', 'ĩ',
            'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
            'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
            'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
            'đ'
        ];

        var noAccents = [
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'd'
        ];

        // Thay thế các dấu bằng các ký tự không dấu
        return str.split('').map(function(char, i) {
            var accentIndex = accents.indexOf(char);
            return accentIndex !== -1 ? noAccents[accentIndex] : char;
        }).join('');
    }
});
