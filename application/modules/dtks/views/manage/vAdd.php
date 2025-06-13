<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-sm-12">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                <div class="iq-card-body">
                    <a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2"> 
                        <i class="ri-arrow-go-back-line"></i> Kembali 
                    </a>
                    <div class="clearfix"></div>
                    
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="single-tab" data-toggle="tab" href="#single" role="tab" aria-controls="single" aria-selected="true">
                                <i class="ri-user-add-line"></i> Tambah NIK
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="import-tab" data-toggle="tab" href="#import" role="tab" aria-controls="import" aria-selected="false">
                                <i class="ri-file-upload-line"></i> Import File
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="myTabContent">
                        <!-- Single NIK Form -->
                        <div class="tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-tab">
                            <div class="iq-advance-course mt-3">
                                <form action="<?= base_url()?>dtks/manage/save" method="POST">
                                    <div class="form-group">
                                        <label for="">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nik" placeholder="Masukkan NIK" autocomplete="off" required maxlength="16" pattern="[0-9]{16}" title="NIK harus 16 digit angka">
                                        <small class="form-text text-muted">NIK harus 16 digit angka</small>
                                    </div>
                                    <!-- Status -->
                                    <div class="form-group">
                                        <label for="">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="" disabled selected>Pilih Status</option>
                                            <option value="Terdaftar">Terdaftar</option>
                                            <option value="Tidak Terdaftar">Tidak Terdaftar</option>
                                        </select>
                                    </div>
                                    <hr>
                                    <!-- Alert -->
                                    <div class="alert alert-warning text-dark">
                                        <i class="ri-information-line"></i>  
                                        Pastikan NIK yang dimasukkan sudah benar dan terdaftar di DTKS.
                                    </div>
                                    <button class="btn btn-primary pull-right" type="submit"> 
                                        <i class="ri-save-line"></i> Simpan 
                                    </button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>

                        <!-- Import File Form -->
                        <div class="tab-pane fade" id="import" role="tabpanel" aria-labelledby="import-tab">
                            <div class="iq-advance-course mt-3">
                                <form action="<?= base_url()?>dtks/manage/import" method="POST" enctype="multipart/form-data" id="importForm">
                                    <div class="alert alert-info">
                                        <h6><i class="ri-information-line"></i> Petunjuk Import:</h6>
                                        <ul class="mb-0">
                                            <li>File Excel (.xlsx, .xls): Kolom pertama (A) harus berisi NIK</li>
                                            <li>Maksimal ukuran file: 5MB</li>
                                        </ul>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Pilih File Import <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control-file" name="import_file" id="import_file" accept=".xlsx,.xls" required>
                                        <small class="form-text text-muted">Format yang didukung: Excel (.xlsx, .xls)</small>
                                    </div>

                                    <div class="form-group" id="csv_options" style="display: none;">
                                        <label for="">Opsi CSV</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="has_header" id="has_header" checked>
                                            <label class="form-check-label" for="has_header">
                                                File memiliki header/judul kolom (baris pertama adalah judul)
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="ignore_duplicate" id="ignore_duplicate" checked>
                                            <label class="form-check-label" for="ignore_duplicate">
                                                Abaikan NIK yang sudah ada (tidak error jika duplikat)
                                            </label>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="alert alert-warning text-dark">
                                        <i class="ri-information-line"></i>  
                                        Pastikan NIK yang di import sudah benar dan terdaftar di DTKS.
                                    </div>
                                    <button class="btn btn-success pull-right" type="submit" id="importBtn"> 
                                        <i class="ri-upload-line"></i> Import Data 
                                    </button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function goBack() {
    window.history.back();
}

// Show/hide CSV options and preview file content
document.getElementById('import_file').addEventListener('change', function() {
    const file = this.files[0];
    const csvOptions = document.getElementById('csv_options');
    const previewContainer = document.getElementById('file_preview');
    
    if (!file) {
        csvOptions.style.display = 'none';
        if (previewContainer) previewContainer.style.display = 'none';
        return;
    }
    
    // Show CSV options for CSV files
    if (file.name.toLowerCase().endsWith('.csv')) {
        csvOptions.style.display = 'block';
    } else {
        csvOptions.style.display = 'none';
    }
    
    // Preview file content
    previewFile(file);
});

function previewFile(file) {
    const maxPreviewSize = 1024 * 1024; // 1MB
    
    if (file.size > maxPreviewSize) {
        showPreview('File terlalu besar untuk preview. Ukuran: ' + formatFileSize(file.size));
        return;
    }
    
    const fileExt = file.name.toLowerCase().split('.').pop();
    
    if (fileExt === 'csv') {
        previewCSV(file);
    } else if (fileExt === 'xlsx' || fileExt === 'xls') {
        previewExcel(file);
    } else if (fileExt === 'sql') {
        previewSQL(file);
    } else {
        showPreview('Format file tidak didukung untuk preview');
    }
}

function previewCSV(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const text = e.target.result;
        const lines = text.split('\n').slice(0, 10); // Ambil 10 baris pertama
        
        let html = '<h6><i class="ri-file-text-line"></i> Preview CSV (10 baris pertama):</h6>';
        html += '<div class="table-responsive"><table class="table table-sm table-bordered">';
        
        lines.forEach((line, index) => {
            if (line.trim()) {
                const cells = parseCSVLine(line);
                html += '<tr>';
                if (index === 0) {
                    cells.forEach(cell => {
                        html += '<th>' + escapeHtml(cell) + '</th>';
                    });
                } else {
                    cells.forEach(cell => {
                        html += '<td>' + escapeHtml(cell) + '</td>';
                    });
                }
                html += '</tr>';
            }
        });
        
        html += '</table></div>';
        html += '<p class="text-muted small">File: ' + file.name + ' (' + formatFileSize(file.size) + ')</p>';
        
        showPreview(html);
    };
    reader.readAsText(file);
}

function previewExcel(file) {
    // Untuk Excel, kita tidak bisa preview dengan mudah di browser
    // Jadi tampilkan informasi file saja
    let html = '<h6><i class="ri-file-excel-line"></i> File Excel Dipilih:</h6>';
    html += '<p><strong>Nama:</strong> ' + file.name + '</p>';
    html += '<p><strong>Ukuran:</strong> ' + formatFileSize(file.size) + '</p>';
    html += '<p><strong>Type:</strong> ' + file.type + '</p>';
    html += '<div class="alert alert-info small">';
    html += '<i class="ri-information-line"></i> ';
    html += 'File Excel akan dibaca saat proses import. Pastikan kolom pertama (A) berisi NIK.';
    html += '</div>';
    
    showPreview(html);
}

function previewSQL(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const text = e.target.result;
        const lines = text.split('\n').slice(0, 20); // Ambil 20 baris pertama
        
        let html = '<h6><i class="ri-database-line"></i> Preview SQL (20 baris pertama):</h6>';
        html += '<pre class="bg-light p-2" style="max-height: 200px; overflow-y: auto;">';
        
        lines.forEach(line => {
            if (line.trim()) {
                html += escapeHtml(line) + '\n';
            }
        });
        
        html += '</pre>';
        html += '<p class="text-muted small">File: ' + file.name + ' (' + formatFileSize(file.size) + ')</p>';
        
        showPreview(html);
    };
    reader.readAsText(file);
}

function showPreview(content) {
    let previewContainer = document.getElementById('file_preview');
    
    if (!previewContainer) {
        // Buat container preview jika belum ada
        previewContainer = document.createElement('div');
        previewContainer.id = 'file_preview';
        previewContainer.className = 'mt-3 p-3 border rounded bg-light';
        
        // Insert setelah form group file input
        const fileGroup = document.querySelector('input[name="import_file"]').closest('.form-group');
        fileGroup.parentNode.insertBefore(previewContainer, fileGroup.nextSibling);
    }
    
    previewContainer.innerHTML = content;
    previewContainer.style.display = 'block';
}

function parseCSVLine(line) {
    const result = [];
    let current = '';
    let inQuotes = false;
    
    for (let i = 0; i < line.length; i++) {
        const char = line[i];
        
        if (char === '"') {
            inQuotes = !inQuotes;
        } else if (char === ',' && !inQuotes) {
            result.push(current.trim());
            current = '';
        } else {
            current += char;
        }
    }
    
    result.push(current.trim());
    return result;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Form validation
document.getElementById('importForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('import_file');
    const file = fileInput.files[0];
    
    if (!file) {
        e.preventDefault();
        alert('Pilih file untuk diimport');
        return;
    }
    
    // Check file size (5MB = 5 * 1024 * 1024 bytes)
    if (file.size > 5 * 1024 * 1024) {
        e.preventDefault();
        alert('Ukuran file terlalu besar. Maksimal 5MB.');
        return;
    }
    
    // Check file extension
    const allowedExts = ['xlsx', 'xls', 'csv', 'sql'];
    const fileExt = file.name.toLowerCase().split('.').pop();
    
    if (!allowedExts.includes(fileExt)) {
        e.preventDefault();
        alert('Format file tidak didukung. Gunakan: ' + allowedExts.join(', '));
        return;
    }
    
    // Show loading
    const importBtn = document.getElementById('importBtn');
    const originalText = importBtn.innerHTML;
    importBtn.innerHTML = '<i class="ri-loader-2-line"></i> Mengimport...';
    importBtn.disabled = true;
    
    // Re-enable button after 30 seconds (timeout protection)
    setTimeout(function() {
        if (importBtn.disabled) {
            importBtn.innerHTML = originalText;
            importBtn.disabled = false;
        }
    }, 30000);
});

// NIK input validation (only numbers, max 16 digits)
document.querySelector('input[name="nik"]').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);
});

// Auto-format NIK display
document.querySelector('input[name="nik"]').addEventListener('blur', function() {
    if (this.value.length === 16) {
        // Format: XXXX-XXXX-XXXX-XXXX
        const formatted = this.value.replace(/(\d{4})(\d{4})(\d{4})(\d{4})/, '$1-$2-$3-$4');
        this.setAttribute('data-formatted', formatted);
    }
});

// Auto-detect delimiter and show suggestion for CSV files
document.getElementById('import_file').addEventListener('change', function() {
    const file = this.files[0];
    const csvOptions = document.getElementById('csv_options');
    
    if (file && file.name.toLowerCase().endsWith('.csv')) {
        csvOptions.style.display = 'block';
        
        // Remove any previous suggestions
        const existingSuggestions = csvOptions.querySelectorAll('.alert-warning');
        existingSuggestions.forEach(s => s.remove());
        
        // Auto-detect delimiter and show suggestion for small files
        if (file.size < 1024 * 100) { // Only for files < 100KB
            const reader = new FileReader();
            reader.onload = function(e) {
                const sample = e.target.result.substring(0, 1000);
                const commaCount = (sample.match(/,/g) || []).length;
                const semicolonCount = (sample.match(/;/g) || []).length;
                
                if (semicolonCount > commaCount) {
                    const suggestion = document.createElement('div');
                    suggestion.className = 'alert alert-warning small mt-2';
                    suggestion.innerHTML = '<i class="ri-information-line"></i> Terdeteksi delimiter semicolon (;). Pastikan file menggunakan koma (,) sebagai separator.';
                    csvOptions.appendChild(suggestion);
                }
            };
            reader.readAsText(file.slice(0, 1000));
        }
    } else {
        csvOptions.style.display = 'none';
        // Remove any previous suggestions
        const suggestions = csvOptions.querySelectorAll('.alert-warning');
        suggestions.forEach(s => s.remove());
    }
});
</script>