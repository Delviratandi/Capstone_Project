<x-layouts.admin title="Manajemen Tipe Pembayaran">
    <div class="container mx-auto p-10">
        <div class="flex items-center gap-4 mb-6">
            <h1 class="text-3xl font-semibold">Manajemen Tipe Pembayaran</h1>
            <button class="btn btn-primary ml-auto" onclick="add_modal.showModal()">Tambah Tipe Pembayaran</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error mb-4">
                <span>Terjadi error. Pastikan input sudah benar.</span>
            </div>
        @endif

        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="w-16">No</th>
                                <th>Nama Tipe Pembayaran</th>
                                <th class="w-56 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paymentTypes as $i => $pt)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $pt->name }}</td>
                                    <td class="text-right space-x-2">
                                        <button
                                            class="btn btn-sm btn-warning"
                                            onclick="openEditModal({{ $pt->id }}, @js($pt->name))"
                                        >
                                            Edit
                                        </button>

                                        <button
                                            class="btn btn-sm btn-error"
                                            onclick="openDeleteModal({{ $pt->id }}, @js($pt->name))"
                                        >
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada tipe pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-sm opacity-70">
                    Contoh tipe pembayaran: Transfer Bank, E-Wallet, Cash.
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: ADD --}}
    <dialog id="add_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold mb-4">Tambah Tipe Pembayaran</h3>

            <form method="POST" action="{{ route('admin.payment-types.store') }}" class="space-y-3">
                @csrf

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Nama Tipe Pembayaran</span>
                    </div>
                    <input
                        type="text"
                        name="name"
                        class="input input-bordered w-full"
                        placeholder="Contoh: Transfer Bank"
                        required
                        value="{{ old('name') }}"
                    />
                    @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </label>

                <div class="modal-action">
                    <button type="button" class="btn" onclick="add_modal.close()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- MODAL: EDIT --}}
    <dialog id="edit_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold mb-4">Edit Tipe Pembayaran</h3>

            <form id="edit_form" method="POST" action="" class="space-y-3">
                @csrf
                @method('PUT')

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Nama Tipe Pembayaran</span>
                    </div>
                    <input
                        type="text"
                        id="edit_name"
                        name="name"
                        class="input input-bordered w-full"
                        required
                    />
                </label>

                <div class="modal-action">
                    <button type="button" class="btn" onclick="edit_modal.close()">Batal</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- MODAL: DELETE --}}
    <dialog id="delete_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold mb-2">Hapus Tipe Pembayaran</h3>
            <p class="mb-4">Yakin mau hapus: <span id="delete_name" class="font-semibold"></span> ?</p>

            <form id="delete_form" method="POST" action="">
                @csrf
                @method('DELETE')

                <div class="modal-action">
                    <button type="button" class="btn" onclick="delete_modal.close()">Batal</button>
                    <button type="submit" class="btn btn-error">Hapus</button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function openEditModal(id, name) {
            const form = document.getElementById('edit_form');
            const input = document.getElementById('edit_name');

            form.action = `{{ url('admin/payment-types') }}/${id}`;
            input.value = name;

            edit_modal.showModal();
        }

        function openDeleteModal(id, name) {
            const form = document.getElementById('delete_form');
            const span = document.getElementById('delete_name');

            form.action = `{{ url('admin/payment-types') }}/${id}`;
            span.textContent = name;

            delete_modal.showModal();
        }
    </script>
</x-layouts.admin>
