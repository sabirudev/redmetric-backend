import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head } from '@inertiajs/inertia-react';

export default function Submission(props) {
    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Submission</h2>}
        >
            <Head title="Submission" />
            <div className="grid grid-cols-6 gap-4 w-3/4 m-auto pt-5">
                <div className="border-t-4 border-purple-500 pt-4">
                    <p className="uppercase text-purple-500 font-bold">Step 1</p>

                    <p className="font-semibold">Job details</p>
                </div>
                <div className="border-t-4 border-purple-500 pt-4">
                    <p className="uppercase text-purple-500 font-bold">Step 2</p>

                    <p className="font-semibold">Application form</p>
                </div>
                <div className="border-t-4 border-gray-200 pt-4">
                    <p className="uppercase text-gray-400 font-bold">Step 3</p>

                    <p className="font-semibold">Preview</p>
                </div>
                <div className="border-t-4 border-gray-200 pt-4">
                    <p className="uppercase text-gray-400 font-bold">Step 4</p>

                    <p className="font-semibold">Preview</p>
                </div>
                <div className="border-t-4 border-gray-200 pt-4">
                    <p className="uppercase text-gray-400 font-bold">Step 5</p>

                    <p className="font-semibold">Preview</p>
                </div>
                <div className="border-t-4 border-gray-200 pt-4">
                    <p className="uppercase text-gray-400 font-bold">Step 6</p>

                    <p className="font-semibold">Preview</p>
                </div>
            </div>
            <div  className="hidden sm:block" aria-hidden="true">
                <div  className="py-5">
                    <div  className="border-t border-gray-200"></div>
                </div>
            </div>
            <div className="grid gap-4 w-3/4 m-auto pt-5">
                <div className="md:grid md:grid-cols-3 md:gap-6">
                    <div className="md:col-span-1">
                        <div className="px-4 sm:px-0">
                            <h3 className="text-lg font-bold leading-6 text-gray-900">Complete 3/6</h3>
                            <p className="mt-1 text-sm text-gray-600">
                                This information will be displayed publicly so be careful what you share.
                            </p>
                        </div>
                    </div>
                    <div className="mt-5 md:mt-0 md:col-span-2">
                        <form action="#" method="POST">
                            <div className="shadow sm:rounded-md sm:overflow-hidden">
                                <div className="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div className="grid grid-cols-3 gap-6">
                                        <div className="col-span-3 sm:col-span-2">
                                            <label for="company-website" className="block text-sm font-medium text-gray-700">
                                                Website
                                            </label>
                                            <div className="mt-1 flex rounded-md shadow-sm">
                                                <span className="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                    http://
                                                </span>
                                                <input type="text" name="company-website" id="company-website" className="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="www.example.com" />
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="about" className="block text-sm font-medium text-gray-700">
                                            About
                                        </label>
                                        <div className="mt-1">
                                            <textarea id="about" name="about" rows="3" className="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="you@example.com"></textarea>
                                        </div>
                                        <p className="mt-2 text-sm text-gray-500">
                                            Brief description for your profile. URLs are hyperlinked.
                                        </p>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700">
                                            Cover photo
                                        </label>
                                        <div className="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div className="space-y-1 text-center">
                                                <svg className="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div className="flex text-sm text-gray-600">
                                                    <label for="file-upload" className="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload a file</span>
                                                        <input id="file-upload" name="file-upload" type="file" className="sr-only" />
                                                    </label>
                                                    <p className="pl-1">or drag and drop</p>
                                                </div>
                                                <p className="text-xs text-gray-500">
                                                    PNG, JPG, GIF up to 10MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit" className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
