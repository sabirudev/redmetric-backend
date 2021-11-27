import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import Uploader from '@/Components/Uploader';
import moment from 'moment'
import Input from '@/Components/Input';
import Label from '@/Components/Label';
import Button from '@/Components/Button';
import ValidationErrors from '@/Components/ValidationErrors';
import UserCard from '@/Components/UserCard';
import ReactDatePicker from 'react-datepicker';

export default function ProfileForm(props) {
    const { membership, village } = props;
    const { data, setData, post, put, processing, errors, reset } = useForm({
        name: village?.name || '',
        since: village?.since ? new Date(village.since) : null,
        address: village?.address || '',
        website: village?.website || '',
        province: village?.province || '',
        head: village?.head || '',
        secretary: village?.secretary || '',
        amount_male: village?.amount_male || '',
        amount_female: village?.amount_female || '',
        amount_productive_age: village?.amount_productive_age || '',
        area: village?.area || '',
        address_longitude: village?.address_longitude || '',
        address_latitude: village?.address_latitude || ''
    });

    const onHandleChange = (event) => {
        if (event.hasOwnProperty('target')) {
            setData(event.target.name, event.target.value);
        } else {
            setData('since', event)
        }
    };

    const submit = (e) => {
        e.preventDefault();
        village?.id ? put(route('dashboard.profile.update', village.id)) : post(route('dashboard.profile.store'));
    }

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Edit Profile</h2>}
        >
            <Head title="Profile Form" />
            <ValidationErrors errors={errors} />
            <div className="container mx-auto my-5 p-5">
                <div className="md:flex no-wrap md:-mx-2 ">
                    <div className="w-full md:w-3/12 md:mx-2">
                        <UserCard {...{ membership, ...props }} />
                    </div>

                    <div className="w-full md:w-9/12 mx-2 h-64">
                        {/* Profile tab */}
                        {/* About Section */}
                        <div className="bg-white p-3 shadow-sm rounded-sm">
                            <div className="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
                                <span clas="text-green-500">
                                    <svg className="h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <span className="tracking-wide">Data Desa / Kelurahan</span>
                            </div>

                            <form onSubmit={submit}>

                                <div className="grid md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <Label forInput="name" value="Nama Desa / Kelurahan" />
                                        <Input
                                            type="text"
                                            name="name"
                                            value={data.name}
                                            autoComplete="name"
                                            handleChange={onHandleChange}
                                            className="mt-1 block w-full"
                                            isFocused={true}
                                            required
                                        />
                                    </div>
                                    <div>
                                        <Label forInput="since" value="Tanggal Berdiri" />
                                        <ReactDatePicker dateFormat="dd-MM-yyyy" name="since" selected={data.since} onChange={onHandleChange} />
                                    </div>
                                    <div>
                                        <Label forInput="head" value="Kepala Desa / Lurah" />
                                        <Input
                                            type="text"
                                            name="head"
                                            value={data.head}
                                            autoComplete="head"
                                            handleChange={onHandleChange}
                                            className="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div>
                                        <Label forInput="address" value="Alamat" />
                                        <textarea
                                            name="address"
                                            defaultValue={data.address}
                                            autoComplete="address"
                                            onChange={onHandleChange}
                                            className="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                                    </div>
                                    <div>
                                        <Label forInput="secretary" value="Sekretaris Desa / Lurah" />
                                        <Input
                                            type="text"
                                            name="secretary"
                                            value={data.secretary}
                                            autoComplete="secretary"
                                            handleChange={onHandleChange}
                                            className="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div>
                                        <Label forInput="province" value="Provinsi" />
                                        <Input
                                            type="text"
                                            name="province"
                                            value={data.province}
                                            autoComplete="province"
                                            handleChange={onHandleChange}
                                            className="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div>
                                        <Label forInput="area" value="Luas Wilayah Desa" />
                                        <Input
                                            type="number"
                                            name="area"
                                            value={data.area}
                                            autoComplete="area"
                                            handleChange={onHandleChange}
                                            className="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div>
                                        <Label forInput="area" value="Alamat Website Official Desa" />
                                        <Input
                                            type="text"
                                            name="website"
                                            value={data.website}
                                            autoComplete="website"
                                            handleChange={onHandleChange}
                                            className="mt-1 block w-full"
                                        />
                                    </div>
                                </div>
                                <div className="grid md:grid-cols-3 gap-3 text-sm">
                                    <div>
                                        <Label forInput="amount_male" value="Jumlah Laki-laki" />
                                        <Input
                                            type="number"
                                            name="amount_male"
                                            value={data.amount_male}
                                            autoComplete="amount_male"
                                            handleChange={onHandleChange}
                                            className="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div>
                                        <Label forInput="amount_female" value="Jumlah Perempuan" />
                                        <Input
                                            type="number"
                                            name="amount_female"
                                            value={data.amount_female}
                                            autoComplete="amount_female"
                                            handleChange={onHandleChange}
                                            className="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div>
                                        <Label forInput="amount_productive_age" value="Jumlah Usia Produktif" />
                                        <Input
                                            type="number"
                                            name="amount_productive_age"
                                            value={data.amount_productive_age}
                                            autoComplete="amount_productive_age"
                                            handleChange={onHandleChange}
                                            className="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                </div>
                                <div className="flex items-center justify-end mt-4 pr-3">
                                    <Button className="ml-4" processing={processing}>
                                        Simpan
                                    </Button>
                                </div>
                            </form>
                        </div>
                        {/* End of about section */}

                        <div className="my-4"></div>

                        {/* Experience and education */}
                        <div className="bg-white p-3 shadow-sm rounded-sm">

                            <div className="grid grid-cols-2">
                                <div>
                                    <div className="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                        <span clas="text-green-500">
                                            <svg className="h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </span>
                                        <span className="tracking-wide">Unggah Identitas Penduduk (KTP) </span>
                                    </div>
                                    <div className="p-3">
                                        <Uploader />
                                    </div>
                                </div>
                                <div>
                                    <div className="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                        <span clas="text-green-500">
                                            <svg className="h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path fill="#fff" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path fill="#fff"
                                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                            </svg>
                                        </span>
                                        <span className="tracking-wide">Unggah Surat Tugas Desa</span>
                                    </div>
                                    <div className="p-3">
                                        <Uploader />
                                    </div>
                                </div>
                            </div>
                            {/* End of Experience and education grid */}

                        </div>
                        {/* End of profile tab */}
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
