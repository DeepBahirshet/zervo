<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProfileService from "@/Services/ProfileService";
import { ref } from "vue";
import { toast } from "vue-sonner";

const props = defineProps({
    user: Object,
});

const defaultAvatar =
    "https://ui-avatars.com/api/?background=f3f4f6&color=374151&size=200&name=";

const imageInput = ref(null);

const profileImage = ref(props.user.profile_image_url);

const uploading = ref(false);

const selectImage = () => {
    imageInput.value.click();
};

const uploadImage = async (e) => {
     const files = event.target?.files

    if (!files || files.length === 0) {
        return
    }

    const file = files[0]

    if (!file) return;

    try {

        uploading.value = false;
        
        await ProfileService.uploadImage(file);

        profileImage.value = URL.createObjectURL(file);

        toast.success("Image Uploaded Successfully");

    } catch (error) {
        console.error(error)
    }
    finally{
         uploading.value = false;
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-3xl">
                            <h1 class="mt-8 mb-6 text-2xl font-bold">
                    My Profile
                </h1>
            <div class="rounded-xl bg-white p-8 shadow">
                <div class="flex flex-col items-center">
                    <img
                        :src="
                            profileImage ??
                            `${defaultAvatar}${user.name}`
                        "
                        :alt="user.name"
                        class="h-36 w-36 rounded-full border-4 border-amber-500 object-cover shadow"
                    />

                    <input
                        ref="imageInput"
                        type="file"
                        class="hidden"
                        accept="image/*"
                        @change="uploadImage"
                    />
                    <button
                        @click="selectImage"
                        class="mt-4 rounded-md bg-amber-500 px-4 py-2 text-white hover:bg-amber-600"
                    >
                        {{ uploading ? "Uploading..." : "Change Photo" }}
                    </button>
                </div>

                <div class="space-y-5">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>

                        <p class="font-medium">
                            {{ user.name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Email</p>

                        <p class="font-medium">
                            {{ user.email }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Phone</p>

                        <p class="font-medium">
                            {{ user.phone ?? "-" }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Member Since</p>

                        <p class="font-medium">
                            {{ new Date(user.created_at).toLocaleDateString() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
