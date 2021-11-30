import React, { useState } from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Button } from '@chakra-ui/button';
import { Box, Grid, GridItem, HStack, Wrap } from '@chakra-ui/layout';
import { ArrowLeftIcon, ArrowRightIcon } from '@chakra-ui/icons';
import ValidationErrors from '@/Components/ValidationErrors';
import Uploader from '@/Components/Uploader';
import Step from '@/Components/Step';
import { FormControl } from '@chakra-ui/form-control';
import { Input } from '@chakra-ui/input';

export default function SubmissionForm(props) {
    const { questions, period, steps } = props;
    const [page, setPage] = useState(1);
    const [tabs, setTabs] = useState(steps)
    const inputs = questions[page];
    const lastKey = parseInt(Object.keys(questions).pop(), 10);

    const { data, setData, post, processing, errors } = useForm(questions);

    const handleOnChangePage = (page) => {
        const modifiedTabs = tabs.map((tab) => ({
            ...tab,
            active: (tab.id === page)
        }))
        setTabs(modifiedTabs);
        setPage(page);
    }

    const onHandleChange = (event) => {
        if (event.hasOwnProperty('target')) {
            const matches = event.target.name?.match(/\[(.*?)\]/);
            const index = parseInt(matches ? matches[1] : 0, 10)
            const obj = {}
            Object.keys(data).forEach((k) => {
                let values = data[k]
                if (parseInt(k, 10) === page) {
                    values = values?.map((v, vx) => ({
                        ...v,
                        value: vx === index ? event.target.value : v.value
                    }))
                }
                obj[k] = values
            })
            setData(obj);
        }
    };

    const submit = (e) => {
        e.preventDefault();
        post(route('dashboard.user.submission.store', period));
    }
    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Submission Form</h2>}
        >
            <Head title="Submission Form" />
            <Step items={tabs} />
            <div className="hidden sm:block" aria-hidden="true">
                <div className="py-5">
                    <div className="border-t border-gray-200"></div>
                </div>
            </div>
            <div className="grid gap-4 w-3/4 m-auto pt-5">
                <div className="md:grid md:grid-cols-3 md:gap-6">
                    <div className="md:col-span-1">
                        <div className="px-4 sm:px-0">
                            {/*<h3 className="text-lg font-bold leading-6 text-gray-900">Complete 3/6</h3>*/}
                            <p className="mt-1 text-sm text-gray-600">
                                This information will be displayed privately so don't be worried what you share, you're save :).
                            </p>
                        </div>
                    </div>
                    <div className="mt-5 md:mt-0 md:col-span-2">
                        <form onSubmit={submit}>
                            <div className="shadow sm:rounded-md sm:overflow-hidden">
                                <div className="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <ValidationErrors errors={errors} />
                                    {inputs && inputs?.map((input, ix) => (
                                        <HStack w="full" key={input.id}>
                                            <Box w="70%">
                                                {input.label}
                                            </Box>
                                            <Box w="30%">
                                                <FormControl>
                                                    <Input
                                                        type="number"
                                                        name={`value[${ix}]`}
                                                        value={data[page][ix]?.value}
                                                        onChange={onHandleChange}
                                                    />
                                                    <Input
                                                        type="hidden"
                                                        name={`input[${ix}]`}
                                                        defaultValue={data[page][ix]?.id}
                                                    />
                                                    <Input
                                                        type="hidden"
                                                        name={`criteria[${ix}]`}
                                                        defaultValue={page}
                                                    />
                                                </FormControl>
                                            </Box>
                                        </HStack>
                                    ))}
                                </div>
                                <div className="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <Grid templateColumns="repeat(5, 1fr)" gap={4}>
                                        <GridItem colSpan={2} h="10" >
                                            <Wrap align="left">
                                                <Button
                                                    variant="ghost"
                                                    disabled={page === 1}
                                                    leftIcon={<ArrowLeftIcon />}
                                                    onClick={() => handleOnChangePage(page - 1)}>
                                                    Previous
                                                </Button>
                                            </Wrap>
                                        </GridItem>
                                        <GridItem colStart={4} colEnd={6} h="10">
                                            <Button
                                                disabled={(lastKey === page)}
                                                variant="ghost"
                                                rightIcon={<ArrowRightIcon />}
                                                onClick={() => handleOnChangePage(page + 1)}>
                                                Next
                                            </Button>
                                            {(lastKey === page)
                                                ? (
                                                    <Button type="submit" className="ml-4" disabled={processing}>
                                                        Submit
                                                    </Button>
                                                ) : null
                                            }
                                        </GridItem>
                                    </Grid>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div >
        </Authenticated>
    );
}
